<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\SubmissionApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Approval;

class SpvController extends Controller
{
    protected $approvalService;


    public function __construct(SubmissionApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function index(Request $request)
    {
        $limit = $request->query('limit', 5);

        $submissions = Submission::with(['user', 'category'])
            ->where('status', 'Waiting SPV Approval')
            ->orderBy('created_at', 'asc')
            ->paginate($limit);

        return view('spv.index', compact('submissions'));
    }

    public function process(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($id);

        if ($submission->status !== 'Waiting SPV Approval') {
            return redirect()->back()->with('error', 'Pengajuan ini tidak sedang dalam tahap approval SPV.');
        }

        // JIKA SPV MENOLAK SECARA MANUAL [cite: 76]
        if ($request->action === 'reject') {
            DB::transaction(function () use ($request, $submission) {
                $submission->status = 'Rejected';
                $submission->save();

                Approval::create([
                    'submission_id' => $submission->id,
                    'user_id'       => Auth::id(),
                    'status'        => 'Rejected',
                    'notes'         => $request->notes,
                ]);
            });

            return redirect()->route('spv.dashboard')->with('success', 'Pengajuan telah ditolak secara manual.');
        }


        $result = $this->approvalService->checkBudgetAndApprove($submission, $request->notes);

        if ($result['status'] === 'Rejected') {
            return redirect()->route('spv.dashboard')->with('error', $result['message']);
        }

        return redirect()->route('spv.dashboard')->with('success', $result['message']);
    }

    public function history(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $limit = $request->query('limit', 5);

        $query = Submission::query()->whereIn('status', ['Waiting Manager', 'Waiting Direktur', 'Waiting Finance', 'Paid', 'Rejected']);

        if ($month) {
            $query->whereMonth('updated_at', $month);
        }
        if ($year) {
            $query->whereYear('updated_at', $year);
        }

        $historySubmissions = $query->with(['user', 'category'])
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        return view('spv.history', compact('historySubmissions'));
    }
}
