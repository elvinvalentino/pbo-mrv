<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'root':
                return redirect()->route('users.index');
            case 'admin_po':
                return redirect()->route('pre-order.index');
            case 'admin_mrv':
                return redirect()->route('request-order.index');
            case 'admin_approval':
                return redirect()->route('approval.index');
            default:
                return view('home');
                
        }
    }
}
