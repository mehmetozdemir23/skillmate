<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard routes
    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::middleware('block_user_edit')->group(function(){
        Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
        Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
        Route::get('/profile/skills/add', [ProfileController::class, 'addSkillForm'])->name('profile.skills.add');
        Route::post('/profile/skills', [ProfileController::class, 'storeSkill'])->name('profile.skills.store');
        Route::delete('/profile/skills/{skill}', [ProfileController::class, 'deleteSkill'])->name('profile.skills.delete');
        Route::delete('/profile/account', [ProfileController::class, 'deleteAccount'])->name('profile.account.delete');
        Route::patch('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.info.update');
        Route::patch('/profile/password', [PasswordController::class, 'update'])->name('profile.password.update');
    });

    // User routes
    Route::prefix('/users')->group(function () {
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    });

    // Mission routes
    Route::prefix('/missions')->group(function () {
        Route::name('missions.')->group(function () {
            Route::get('/', [MissionController::class, 'index'])->name('index');
            Route::post('/{mission}/start', [MissionController::class, 'start'])->name('start');
            Route::post('/{mission}/end', [MissionController::class, 'end'])->name('end');
        });

        Route::prefix('/{mission}')->group(function () {
            Route::get('/review/create', [ReviewController::class, 'create'])->name('reviews.create');
            Route::post('/review/store', [ReviewController::class, 'store'])->name('reviews.store');
        });
    });

    // Service request routes
    Route::get('/service-requests/received', [ServiceRequestController::class, 'receivedServiceRequests'])->name('serviceRequests.received');
    Route::get('/service-requests/sent', [ServiceRequestController::class, 'sentServiceRequests'])->name('serviceRequests.sent');

    // Service board routes
    Route::get('/service-board', [ServiceController::class, 'allServices'])->name('serviceBoard');

    // Service routes
    Route::prefix('/services')->group(function () {
        Route::name('services.')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('index');
            Route::get('/create', [ServiceController::class, 'create'])->name('create');
            Route::post('/', [ServiceController::class, 'store'])->name('store');
            Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/{service}')->group(function () {
            Route::prefix('/requests')->name('serviceRequests.')->group(function () {
                Route::get('/create', [ServiceRequestController::class, 'create'])->name('create');
                Route::post('/store', [ServiceRequestController::class, 'store'])->name('store');

                Route::prefix('/{serviceRequest}')->group(function () {
                    Route::get('/', [ServiceRequestController::class, 'show'])->name('show');
                    Route::post('/accept', [ServiceRequestController::class, 'accept'])->name('accept');
                    Route::post('/decline', [ServiceRequestController::class, 'decline'])->name('decline');
                    Route::post('/undo', [ServiceRequestController::class, 'undo'])->name('undo');
                    Route::delete('/', [ServiceRequestController::class, 'destroy'])->name('destroy');
                });
            });
            Route::get('/reviews', [ServiceController::class, 'showReviews'])->name('reviews.show');
        });
    });

});

require __DIR__ . '/auth.php';