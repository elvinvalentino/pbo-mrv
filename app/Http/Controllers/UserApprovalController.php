<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index() {
        $positions = Position::orderBy('level')->get();
        $arrPositions = $positions->toArray();

        $heads = array_map(function($position) {
            return 'Level ' . $position['level'];
        }, $arrPositions);

        $rowLength = 0;

        $datas = array();
        foreach ($positions as $position) {
            $users = $position->users()->get()->toArray();
            array_push($datas, $users ?? []);
            if(count($users) > $rowLength) $rowLength = count($users);
        }

        return view('user-approvals/list', ['heads' => $heads, 'datas' => $datas, 'rowLength' => $rowLength]);
    }
}
