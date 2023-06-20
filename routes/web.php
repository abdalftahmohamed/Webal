<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Amestsantim\Voucherator\VoucherGenerator;
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

Route::get('/voucher', function () {
    return view('voucher');
});

Route::get('/store', function () {
    return view('store');
});

Route::get('/video', function () {
    return view('video');
});
Route::get('/magazine', function () {
    return view('magazine');
});

Route::get('/notification', function () {
    return view('notification');
});

Route::get('/performance', function () {
    return view('performance');
});

Route::get('/subscripe', function () {
    return view('subscripe');
});

Route::get('/subscripe2', function () {
    return view('subscripe2');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/vo', function () {
    $v = new VoucherGenerator();
    return  $v->letters()->length(12)->lowerCase()->generate()[0];
});
