<?php

namespace App\Http\Controllers;

use App\Models\RequestOrder;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class RequestOrderController extends Controller
{
    public function index() {
        $requestOrders = RequestOrder::where('user_id', Auth::id());
        
        return view('request-orders/list', [
            'requestOrders' => $requestOrders,
        ]);
    }

    public function create()
    {
        $products = Product::all();

        return view('request-orders/create', [
            'products' => $products
        ]);
    }
}
