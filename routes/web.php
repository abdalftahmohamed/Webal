<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('single-charge', [SubscriptionController::class, 'singleCharge'])->name('single.charge');
Route::get('plans/create', [SubscriptionController::class, 'showPlanForm'])->name('plans.create');
Route::post('plans/store', [SubscriptionController::class, 'savePlan'])->name('plans.store');


Route::get('plans', [SubscriptionController::class, 'allPlans'])->name('plans.all');
Route::get('plans/checkout/{planId}', [SubscriptionController::class, 'checkout'])->name('plans.checkout');
Route::post('plans/process', [SubscriptionController::class, 'processPlan'])->name('plan.process');

Route::get('subscriptions/all', [SubscriptionController::class, 'allSubscriptions'])->name('subscriptions.all');
Route::get('subscriptions/cancel', [SubscriptionController::class, 'cancelSubscriptions'])->name('subscriptions.cancel');
Route::get('subscriptions/resume', [SubscriptionController::class, 'resumeSubscriptions'])->name('subscriptions.resume');



require __DIR__.'/auth.php';
