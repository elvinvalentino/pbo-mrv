<?php

namespace App\Http\Controllers;

use App\Models\RequestOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreOrderController extends Controller
{
    public function index() {
        $requestOrders = RequestOrder::where('status', 'open')->get();

        return view('pre-orders/list', [
            'requestOrders' => $requestOrders,
        ]);
    }

    public function show(RequestOrder $requestOrder) {
        return view('pre-orders/show', ['requestOrder' => $requestOrder]);
    }
}
