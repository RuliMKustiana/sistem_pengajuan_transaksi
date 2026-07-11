<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\Approval;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionApprovalService
{
    /**
     * Memproses pengecekan budget dan mengembalikan status serta catatan otomatis.
     */
    public function checkBudgetAndApprove(Submission $submission, ?string $userNotes): array
    {
        // 1. Ambil data budget aktif untuk kategori ini di tahun berjalan
        $budget = Budget::where('category_id', $submission->category_id)
            ->where('fiscal_year', now()->format('Y'))
            ->first();

        // 2. Hitung total akumulasi pengajuan yang sudah disetujui/sedang berjalan
        $totalTerpake = Submission::where('category_id', $submission->category_id)
            ->whereIn('status', ['Paid', 'Waiting Manager Approval', 'Waiting Director Approval', 'Waiting Finance'])
            ->whereYear('submission_date', now()->format('Y'))
            ->sum('amount');

        $statusPencatatan = 'Approved';
        $catatanFinal = $userNotes;

        // 3. FLOWCHART CHECK: Jika budget tidak ada atau sisa limit tidak cukup, otomatis REJECT
        if (!$budget || ($budget->amount - $totalTerpake < $submission->amount)) {
            $submission->status = 'Rejected';
            $statusPencatatan = 'Rejected';
            $catatanFinal = '[Sistem Otomatis] Di-reject karena sisa budget kategori tidak mencukupi.';
        } else {
            // Jika budget aman, naikkan status ke antrean Manager
            $submission->status = 'Waiting Manager Approval';
        }

        // 4. Bungkus dalam Database Transaction agar eksekusi sinkron
        DB::transaction(function () use ($submission, $statusPencatatan, $catatanFinal) {
            $submission->save();

            Approval::create([
                'submission_id' => $submission->id,
                'user_id'       => Auth::id(),
                'status'        => $statusPencatatan,
                'notes'         => $catatanFinal,
            ]);
        });

        return [
            'status'  => $statusPencatatan,
            'message' => $statusPencatatan === 'Approved' 
                ? 'Pengajuan berhasil disetujui dan diteruskan ke Manager!' 
                : 'Pengajuan otomatis ditolak sistem karena over-budget.'
        ];
    }
}