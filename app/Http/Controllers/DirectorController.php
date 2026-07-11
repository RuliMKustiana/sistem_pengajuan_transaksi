<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function index(Request $request)
    {
        // Direktur hanya melihat pengajuan berstatus 'Waiting Director Approval'
        $limit = $request->query('limit', 5);
        $submissions = Submission::with(['user', 'category'])
            ->where('status', 'Waiting Director Approval')
            ->orderBy('created_at', 'asc')
            ->paginate($limit);

        return view('direktur.index', compact('submissions'));
    }

    public function process(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($id);

        if ($submission->status !== 'Waiting Director Approval') {
            return redirect()->back()->with('error', 'Pengajuan tidak dalam tahap approval Direktur.');
        }

        DB::transaction(function () use ($request, $submission) {
            if ($request->action === 'approve') {
                // Aturan Kondisi 1 & 4: Jika disetujui Direktur, lanjut ke Finance
                $submission->status = 'Waiting Finance';
                $statusPencatatan = 'Approved';
            } else {
                $submission->status = 'Rejected';
                $statusPencatatan = 'Rejected';
            }
            $submission->save();

            Approval::create([
                'submission_id' => $submission->id,
                'user_id'       => Auth::id(),
                'status'        => $statusPencatatan,
                'notes'         => $request->notes,
            ]);
        });

        $pesan = $request->action === 'approve' ? 'Pengajuan berhasil disetujui dan diteruskan ke Finance!' : 'Pengajuan telah ditolak.';
        return redirect()->route('direktur.dashboard')->with('success', $pesan);
    }

    public function history(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $limit = $request->query('limit', 5);

        $query = Submission::query()->whereIn('status', ['Waiting Finance', 'Paid', 'Rejected']);

        if ($month) {
            $query->whereMonth('updated_at', $month);
        }
        if ($year) {
            $query->whereYear('updated_at', $year);
        }

        $historySubmissions = $query->with(['user', 'category'])
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        return view('direktur.history', compact('historySubmissions'));
    }
}
