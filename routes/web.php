<?php

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

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('sk.index');
    }

    return redirect('/auth');
});
Route::middleware(['auth'])->group(function () {

    // Export Excel
    Route::get('sk_number/excel', [\App\Http\Controllers\SkNumberWebController::class, 'excel'])
        ->name('sk.excel');

    // Resource SK Number
    Route::resource('sk_number', \App\Http\Controllers\SkNumberWebController::class)->names([
        'index'   => 'sk.index',
        'create'  => 'sk.create',
        'store'   => 'sk.store',
        'show'    => 'sk.show',
        'edit'    => 'sk.edit',
        'update'  => 'sk.update',
        'destroy' => 'sk.destroy',
    ]);

});
Route::get('/auth', function () {
    if (auth()->check()) {
        return redirect()->route('sk.index');
    }
    return view('auth.login');
})->name('login');
Route::post('/auth', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
