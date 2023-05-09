<?php

use App\Http\Controllers\ApprovalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RequestOrderController;
use App\Http\Controllers\UserApprovalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('user-approval');
Route::prefix('/request-orders')->group(function() {
    Route::get('/', [RequestOrderController::class, 'index'])->name('request-order.index');
    Route::get('/create', [RequestOrderController::class, 'create'])->name('request-order.create');
    Route::post('/', [RequestOrderController::class, 'store'])->name('request-order.store');
    Route::get('/{requestOrder}', [RequestOrderController::class, 'show'])->name('request-order.show');
    Route::get('/{requestOrder}/edit', [RequestOrderController::class, 'edit'])->name('request-order.edit');
    Route::put('/{requestOrder}', [RequestOrderController::class, 'update'])->name('request-order.update');
    Route::delete('/{requestOrder}', [RequestOrderController::class, 'delete'])->name('request-order.delete');
});
Route::prefix('/approvals')->group(function() {
    Route::get('/', [ApprovalController::class, 'index'])->name('approval.index');
    Route::get('/{requestOrderApproval}', [ApprovalController::class, 'show'])->name('approval.show');
    Route::post('/{requestOrderApproval}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/{requestOrderApproval}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
});
Route::resources([
    'users' => UserController::class,
    'departments' => DepartmentController::class,
    'products' => ProductController::class,
    'positions' => PositionController::class,
]);
