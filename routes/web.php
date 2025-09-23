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
    return view('app');
});
Route::resource('sk_number', \App\Http\Controllers\SkNumberWebController::class)->names([
    'index'   => 'sk.index',
    'create'  => 'sk.create',
    'store'   => 'sk.store',
    'show'    => 'sk.show',
    'edit'    => 'sk.edit',
    'update'  => 'sk.update',
    'destroy' => 'sk.destroy',
]);
