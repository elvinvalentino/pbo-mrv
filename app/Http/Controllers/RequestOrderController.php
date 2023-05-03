<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestOrder\StoreRequestOrderRequest;
use App\Models\Position;
use App\Models\RequestOrder;
use App\Models\Product;
use App\Models\RequestOrderApproval;
use App\Models\RequestOrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;


class RequestOrderController extends Controller
{
    public function index() {
        $requestOrders = RequestOrder::where('user_id', Auth::id())->get();

        return view('request-orders/list', [
            'requestOrders' => $requestOrders,
        ]);
    }

    public function create()
    {
        $products = Product::all();
        $positionLevel2 = Position::where('level', 1)->first();
        $users = $positionLevel2->users()->get();

        return view('request-orders/create', [
            'products' => $products,
            'users' => $users
        ]);
    }

    public function store(StoreRequestOrderRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function() use ($validated) {
            $requestOrder = RequestOrder::create([
                'user_id' => Auth::id(),
                'status' => 'pending_approval',
                'requested_at' => now(),
                'total' => 0,
            ]);

            $user = User::findOrFail($validated['user_id']);
            RequestOrderApproval::create([
                'request_order_id' => $requestOrder->id,
                'user_id' => $user->id,
                'level' => 1,
                'status' => 'pending',
                'approved_at' => null
            ]);

            $totalPrice = 0;
            foreach($validated['products'] as $productInput) {
                $product = Product::findOrFail($productInput['id']);
                $subTotal = $product->unit_price * $productInput['quantity'];
                $totalPrice += $subTotal;
                        
                RequestOrderDetail::create([
                    'request_order_id' => $requestOrder->id,
                    'product_id' => $product->id,
                    'quantity' => $productInput['quantity'],
                    'uom' => $product->uom,
                    'rate' => $product->unit_price,
                    'sub_total' => $subTotal
                ]);
            }

            $requestOrder->update([
                'total' => $totalPrice
            ]);
        });


        return redirect()->route('request-order.index');
    }

    public function show(RequestOrder $requestOrder) {

    }

    public function edit(RequestOrder $requestOrder) {

    }

    public function update(StoreRequestOrderRequest $storeRequestOrderRequest, RequestOrder $requestOrder) {

    }

    public function delete(RequestOrder $requestOrder) {
        
    }
}
