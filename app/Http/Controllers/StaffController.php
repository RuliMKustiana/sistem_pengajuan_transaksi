<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * 1. Menampilkan Dashboard Staff (Daftar Riwayat Pengajuan)
     */
    public function index(Request $request)
    {
        // Ambil data pengajuan khusus milik staff yang sedang login saat ini
        $limit = $request->query('limit', 5);
        $submissions = Submission::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        // Nanti kita akan buat file view ini di folder resources/views/staff/index.blade.php
        return view('staff.index', compact('submissions'));
    }

    /**
     * 2. Menampilkan Form Buat Pengajuan Baru
     */
    public function create()
    {
        // Ambil semua data kategori untuk isi dropdown di form pengajuan
        $categories = Category::all();

        return view('staff.create', compact('categories'));
    }

    /**
     * 3. Menyimpan Data Pengajuan ke Database (Store)
     */
    public function store(Request $request)
    {
        // Validasi input form sesuai spesifikasi dokumen soal
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'amount'           => 'required|numeric|min:1',
            'description'      => 'required|string',
            'attachment_file'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Maksimal 5 MB
        ]);

        // Logika Auto-Generate Nomor Pengajuan (Contoh hasil: REQ-20260708-0001)
        $dateCode = now()->format('Ymd');
        $lastSubmission = Submission::whereDate('created_at', now()->toDateString())->latest()->first();
        $nextNumber = $lastSubmission ? ((int) substr($lastSubmission->submission_number, -4)) + 1 : 1;
        $submissionNumber = 'REQ-' . $dateCode . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Proses Upload File Menggunakan Laravel Storage
        $attachmentPath = null;
        if ($request->hasFile('attachment_file')) {
            // File akan disimpan di folder storage/app/public/attachments
            $attachmentPath = $request->file('attachment_file')->store('attachments', 'public');
        }

        // Tentukan alur workflow awal berdasarkan kategori "PO Produk" atau nilai nominal
        $category = Category::find($request->category_id);
        
        if ($category && $category->name === 'PO Produk') {
            // Kondisi 1: Jika PO Produk langsung ke Direktur
            $statusAwal = 'Waiting Director Approval';
        } else {
            // Kondisi 2: Jika bukan PO Produk dan nilai > 5 Juta, masuk ke SPV dulu
            $statusAwal = ($request->amount > 5000000) ? 'Waiting SPV Approval' : 'Submitted';
        }

        // Simpan data ke tabel submissions
        Submission::create([
            'submission_number' => $submissionNumber,
            'submission_date'   => now()->toDateString(),
            'user_id'           => Auth::id(),
            'category_id'       => $request->category_id,
            'amount'            => $request->amount,
            'description'       => $request->description,
            'attachment'        => $attachmentPath,
            'status'            => $statusAwal,
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Pengajuan transaksi berhasil dibuat dan masuk ke dalam antrean workflow!');
    }
}