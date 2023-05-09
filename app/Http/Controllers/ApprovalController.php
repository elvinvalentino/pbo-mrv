<?php

namespace App\Http\Controllers;

use App\Http\Requests\Approval\ApproveApprovalRequest;
use App\Models\Config;
use App\Models\RequestOrder;
use App\Models\RequestOrderApproval;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApprovalController extends Controller
{
    public function index() {
        $pendingApprovals = RequestOrderApproval::where([
            ['user_id', '=', Auth::id()],
            ['status', '=', 'pending']
        ])->get();
        $completedApprovals = RequestOrderApproval::where([
            ['user_id', '=', Auth::id()],
            ['status', '!=', 'pending']
        ])->get();

        return view('approvals/list', [
            'pendingApprovals' => $pendingApprovals,
            'completedApprovals' => $completedApprovals
        ]);
    }

    public function show(RequestOrderApproval $requestOrderApproval) {
        $nextLevel= Position::where('level', $requestOrderApproval->level + 1)->first();
        $users = $nextLevel->users()->get();

        return view('approvals/show', [
            'requestOrderApproval' => $requestOrderApproval,
            'users' => $users,
            'isMaxLevel' => $this->isMaxLevel($requestOrderApproval->level) ? 1 : 0
        ]);
    }

    public function approve(ApproveApprovalRequest $request, RequestOrderApproval $requestOrderApproval) {
        if($requestOrderApproval->status != 'pending') return redirect()->route('approval.index');

        DB::transaction(function() use ($requestOrderApproval, $request) {
            $requestOrderApproval->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

            if($this->isMaxLevel($requestOrderApproval->level)) {
                $requestOrder = RequestOrder::find($requestOrderApproval->request_order_id);
                $requestOrder->update([
                    'status' => 'open'
                ]);
            } else {
                $validated = $request->validated();
    
                $user = User::findOrFail($validated['user_id']);
                RequestOrderApproval::create([
                    'request_order_id' => $requestOrderApproval->request_order_id,
                    'user_id' => $user->id,
                    'level' => $requestOrderApproval->level + 1,
                    'status' => 'pending',
                    'approved_at' => null
                ]);
            }
        });

        return redirect()->route('approval.index');
    }

    public function reject(Request $request, RequestOrderApproval $requestOrderApproval) {
        if($requestOrderApproval->status != 'pending') return redirect()->route('approval.index');

        DB::transaction(function() use ($requestOrderApproval, $request) {
            $requestOrderApproval->update([
                'status' => 'rejected',
            ]);

            $requestOrder = RequestOrder::find($requestOrderApproval->request_order_id);
            $requestOrder->update([
                'status' => 'rejected'
            ]);

        });

        return redirect()->route('approval.index');
    }

    function isMaxLevel($level) {
        $maxLevelConfig = Config::where('name', 'MAXIMUM_LEVEL_APPROVAL')->first();
        return $level == $maxLevelConfig->value;
    }
}
