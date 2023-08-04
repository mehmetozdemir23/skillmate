<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Models\ServiceRequest;
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

Route::get('/', fn () => redirect()->route('serviceBoard'));

Route::get('/service-board', [ServiceController::class, 'serviceBoard'])->middleware(['auth', 'verified'])->name('serviceBoard');

Route::get('/profile', [ProfileController::class, 'show'])->middleware(['auth', 'verified'])->name('profile.show');
Route::patch('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])->middleware(['auth', 'verified'])->name('profile.updateAvatar');
Route::patch('/profile/update-info', [ProfileController::class, 'updateInfo'])->middleware(['auth', 'verified'])->name('profile.updateInfo');
Route::patch('/profile/update-password', [PasswordController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.updatePassword');

Route::get('/services', [ServiceController::class, 'userServices'])->middleware(['auth', 'verified'])->name('services.userServices');
Route::get('/services/create', [ServiceController::class, 'create'])->middleware(['auth', 'verified'])->name('services.create');
Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->middleware(['auth', 'verified'])->name('services.edit');
Route::put('/services/{service}', [ServiceController::class, 'update'])->middleware(['auth', 'verified'])->name('services.update');
Route::post('/services', [ServiceController::class, 'store'])->middleware(['auth', 'verified'])->name('services.store');
Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->middleware(['auth', 'verified'])->name('services.destroy');

Route::prefix('/service-requests')->name('serviceRequests.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('serviceRequests.received');
    })->middleware(['auth', 'verified'])->name('index');

    Route::get('/create', [ServiceRequestController::class,'create'])->middleware(['auth','verified'])->name('create');
    Route::post('/store', [ServiceRequestController::class,'store'])->middleware(['auth','verified'])->name('store');
    Route::get('/received', [ServiceRequestController::class, 'serviceRequestsReceived'])->middleware(['auth', 'verified'])->name('received');
    Route::get('/sent', [ServiceRequestController::class, 'ServiceRequestsSent'])->middleware(['auth', 'verified'])->name('sent');
    Route::get('{serviceRequest}',[ServiceRequestController::class,'show'])->middleware(['auth', 'verified'])->name('show');
    Route::put('{serviceRequest}/accept',[ServiceRequestController::class,'accept'])->middleware(['auth', 'verified'])->name('accept');
    Route::put('{serviceRequest}/decline',[ServiceRequestController::class,'decline'])->middleware(['auth', 'verified'])->name('decline');
    Route::put('{serviceRequest}/undo',[ServiceRequestController::class,'undo'])->middleware(['auth', 'verified'])->name('undo');
    Route::delete('{serviceRequest}', [ServiceRequestController::class, 'destroy'])->middleware(['auth', 'verified'])->name('destroy');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
