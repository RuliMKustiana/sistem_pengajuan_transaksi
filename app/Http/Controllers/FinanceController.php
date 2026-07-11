<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Payment;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 5);
        $submissions = Submission::with(['user', 'category'])
            ->where('status', 'Waiting Finance')
            ->orderBy('created_at', 'asc')
            ->paginate($limit);

        $budgets = Budget::where('fiscal_year', date('Y'))->get();

        return view('finance.index', compact('submissions', 'budgets'));
    }

    public function pay($id)
    {
        $submission = Submission::findOrFail($id);

        if ($submission->status !== 'Waiting Finance') {
            return redirect()->back()->with('error', 'Pengajuan ini belum siap dibayar.');
        }

        // 1. CARI PLAFON ANGGARAN YANG SESUAI DENGAN KATEGORI & TAHUN PENGAJUAN
        $currentYear = $submission->created_at->format('Y');
        $budget = Budget::where('category_id', $submission->category_id)
                        ->where('fiscal_year', $currentYear)
                        ->first();

        // 2. JIKA PLAFON ANGGARAN BELUM DISETTING OLEH ADMIN
        if (!$budget) {
            return redirect()->back()->with('error', 'Pembayaran Ditolak: Plafon anggaran untuk kategori ini belum dialokasikan oleh Admin.');
        }

        // 3. VALIDASI: Cek apakah nominal pengajuan melebihi plafon yang tersedia
        if ($submission->amount > $budget->balance) { // Asumsi kolom sisa saldo plafon bernama 'balance' atau 'amount'
            
            // Opsional: Otomatis ubah status menjadi Rejected agar antrean bersih
            $submission->status = 'Rejected';
            $submission->save();

            return redirect()->route('finance.dashboard')->with('error', 'Pembayaran Otomatis Ditolak: Nilai pengajuan melebihi sisa Plafon Anggaran Kategori (' . $submission->category->name . ').');
        }

        // 4. JIKA LOLOS VALIDASI, POTONG SALDO PLAFON DAN KUNCI TRANSAKSI
        DB::transaction(function () use ($submission, $budget) {
            // Kurangi saldo plafon anggaran kategori
            $budget->balance -= $submission->amount;
            $budget->save();

            // Set status menjadi Paid
            $submission->status = 'Paid';
            $submission->save();

            // Catat riwayat pembayaran
            Payment::create([
                'submission_id' => $submission->id,
                'user_id'       => Auth::id(),
                'payment_date'  => now()->toDateString(),
            ]);
        });

        return redirect()->route('finance.dashboard')->with('success', 'Pengajuan transaksi berhasil dibayarkan dan memotong plafon anggaran kategori!');
    }

    public function history(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $limit = $request->query('limit', 5);

        // Query dasar: Hanya ambil data yang sudah sukses dibayarkan
        $query = Submission::query()->where('status', 'paid');

        // Terapkan filter jika diisi oleh user
        if ($month) {
            $query->whereMonth('updated_at', $month);
        }
        if ($year) {
            $query->whereYear('updated_at', $year);
        }

        // Urutkan dari yang paling baru dibayar
        $historySubmissions = $query->with(['user', 'category'])
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        return view('finance.history', compact('historySubmissions'));
    }

    public function export(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        if (!$year) {
            $year = date('Y');
        }

        // Query mengambil data yang hanya berstatus 'paid' (Sudah dibayar)
        $query = Submission::query()->where('status', 'paid');

        if ($month) {
            $query->whereMonth('updated_at', $month);
        }

        $query->whereYear('updated_at', $year);

        $submissions = $query->with(['user', 'category'])->get();

        $fileName = 'Laporan_Transaksi_Lavanaya_' . ($month ? $month . '_' : '') . $year . '.csv';

        // Header untuk memaksa browser men-download file sebagai CSV
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Proses pembuatan file CSV secara langsung di memori stream
        $callback = function () use ($submissions) {
            $file = fopen('php://output', 'w');

            // Agar Excel bisa membaca simbol mata uang dan karakter khusus dengan rapi (BOM)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Judul kolom di file Excel/CSV
            fputcsv($file, [
                'No. Pengajuan',
                'Tanggal Dibayar',
                'Nama Pengaju (Karyawan)',
                'Kategori Transaksi',
                'Deskripsi Rincian',
                'Jumlah Nominal Dana'
            ]);

            // Looping memasukkan baris data transaksi Lavanaya
            foreach ($submissions as $submission) {
                fputcsv($file, [
                    $submission->submission_number,
                    $submission->updated_at->format('d-m-Y H:i'),
                    $submission->user->name,
                    $submission->category->name,
                    $submission->description,
                    'Rp ' . number_format($submission->amount, 0, ',', '.')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
