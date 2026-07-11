<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    /**
     * 1. Menampilkan Daftar Pengajuan Menunggu Approval Manager
     */
    public function index(Request $request)
    {
        // Manager hanya melihat pengajuan dengan status 'Waiting Manager Approval'
        $limit = $request->query('limit', 5);
        $submissions = Submission::with(['user', 'category'])
            ->where('status', 'Waiting Manager Approval')
            ->orderBy('created_at', 'asc')
            ->paginate($limit);

        return view('manager.index', compact('submissions'));
    }

    /**
     * 2. Memproses Aksi Approval / Reject dari Manager
     */
    public function process(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($id);

        if ($submission->status !== 'Waiting Manager Approval') {
            return redirect()->back()->with('error', 'Pengajuan ini tidak sedang dalam tahap approval Manager.');
        }

        DB::transaction(function () use ($request, $submission) {
            if ($request->action === 'approve') {
                if ($submission->amount > 10000000) {
                    $submission->status = 'Waiting Director Approval';
                } else {
                    $submission->status = 'Waiting Finance';
                }
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

        return redirect()->route('manager.dashboard')->with('success', 'Pengajuan berhasil diteruskan sesuai batas nominal.');
    }

    public function history(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $limit = $request->query('limit', 5);

        $query = Submission::query()->whereIn('status', ['Waiting Direktur', 'Waiting Finance', 'Paid', 'Rejected']);

        if ($month) {
            $query->whereMonth('updated_at', $month);
        }
        if ($year) {
            $query->whereYear('updated_at', $year);
        }

        $historySubmissions = $query->with(['user', 'category'])
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        return view('manager.history', compact('historySubmissions'));
    }
}
