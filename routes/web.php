<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth')->group(function () {
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/search-lhr', [\App\Http\Controllers\DashboardController::class, 'search_lhr'])->middleware(['auth', 'verified'])->name('search-lhr');
    Route::post('chart/get-ops-data', [\App\Http\Controllers\DashboardController::class, 'get_ops_data'])->name('chart.get-ops-data');

    Route::post('chart/get-mgmt-data', [\App\Http\Controllers\DashboardController::class, 'get_mgmt_data'])->name('chart.get-mgmt-data');
    Route::post('chart/get-mgmt-gross-profit-data', [\App\Http\Controllers\DashboardController::class, 'get_mgmt_gross_profit_data'])->name('chart.get-mgmt-gross-profit-data');
    Route::post('chart/get-mgmt-shipments-data', [\App\Http\Controllers\DashboardController::class, 'get_mgmt_shipments_data'])->name('chart.get-mgmt-shipment-data');
    Route::post('chart/get-mgmt-non-invoiced-data', [\App\Http\Controllers\DashboardController::class, 'get_mgmt_non_invoiced_data'])->name('chart.get-mgmt-non-invoiced-data');

    Route::post('dashboard/search', [\App\Http\Controllers\DashboardController::class, 'search_graph_data'])->name('chart.search-graph-data');

    Route::get('/lhr-list/{status?}', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders');
    Route::get('/export-lhr', [\App\Http\Controllers\OrderController::class, 'exportOrders'])->name('export-lhr');
    Route::post('/lhr-list/{status?}', [\App\Http\Controllers\OrderController::class, 'search'])->name('search-order');
    Route::get('/lhr-list/{id}/comments', [\App\Http\Controllers\OrderController::class, 'comments'])->name('order-comments');
    Route::post('/lhr-list/{id}/store-comment', [\App\Http\Controllers\OrderController::class, 'store_comment'])->name('order-store-comment');
    Route::get('/lhr-list/{id}/claim', [\App\Http\Controllers\OrderController::class, 'claim'])->name('order-claim');
    Route::get('/lhr-list/{id}/processed', [\App\Http\Controllers\OrderController::class, 'processed'])->name('order-processed');
    Route::get('/lhr-list/{id}/close', [\App\Http\Controllers\OrderController::class, 'close'])->name('order-close');
    Route::get('/lhr-list/{id}/view', [\App\Http\Controllers\OrderController::class, 'show'])->name('order-view');
    Route::get('/lhr-list/{id}/edit', [\App\Http\Controllers\OrderController::class, 'edit'])->name('order-edit');
    Route::post('/lhr-list/{id}/update', [\App\Http\Controllers\OrderController::class, 'update'])->name('order-update');
    Route::get('/lhr-create', [\App\Http\Controllers\OrderController::class, 'create_lhr'])->name('order-create');
    Route::post('/lhr-store', [\App\Http\Controllers\OrderController::class, 'store_lhr'])->name('order-store');



    Route::get('roles', [\App\Http\Controllers\RolesController::class, 'index'])->name('roles');
    Route::get('role-create', [\App\Http\Controllers\RolesController::class, 'create'])->name('role-create');
    Route::post('role-store', [\App\Http\Controllers\RolesController::class, 'store'])->name('role-store');
    Route::get('roles/edit/{id}', [\App\Http\Controllers\RolesController::class, 'edit'])->name('role-edit');
    Route::post('roles/update/{id}', [\App\Http\Controllers\RolesController::class, 'update'])->name('role-update');
    Route::post('roles/update/role-permissions/{id}', [\App\Http\Controllers\RolesController::class, 'updateRolePermissions'])->name('update-role-permissions');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/remove-image/{user}', [ProfileController::class, 'remove_image'])->name('profile.remove-image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/user-change-status/{id}', [\App\Http\Controllers\UserController::class, 'user_change_status'])->name('user-change-status');
    Route::get('user/create', [\App\Http\Controllers\UserController::class, 'create'])->name('register');
    Route::post('user/store', [\App\Http\Controllers\UserController::class, 'store'])->name('user-store');
    Route::get('getUserDetails/{id}', [\App\Http\Controllers\UserController::class, 'getUserDetails'])->name('getUserDetails');
    Route::post('updateUserDetails/{id}', [\App\Http\Controllers\UserController::class, 'updateUserDetails'])->name('updateUserDetails');
});

require __DIR__.'/auth.php';




