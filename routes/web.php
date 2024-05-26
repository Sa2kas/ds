<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/contacts', function () {
    return Inertia::render('Contacts', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/exterior_doors', function () {
    return Inertia::render('ExteriorDoors', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/interior_doors', function () {
    return Inertia::render('InteriorDoors', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/dashboard_admin', function () {
    //     return Inertia::render('AdminDashboard');
    // })->name('admin.dashboard');

    // Route::get('/dashboard_manager', function () {
    //     return Inertia::render('ManagerDashboard');
    // })->name('manager.dashboard');

    // Route::get('/dashboard_user', function () {
    //     return Inertia::render('Dashboard');
    // })->name('user.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/user-management', function () {
    //     return Inertia::render('UserManagement');
    // })->name('user.management');

    // Register resource routes for UserController under admin role protection
    // Route::resource('users', UserController::class);
    Route::get('/dashboard_admin', function () {
        return Inertia::render('AdminDashboard');
    })->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Route to store (create or update) a user
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    // Route to delete a user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/dashboard_manager', function () {
        return Inertia::render('ManagerDashboard');
    })->name('manager.dashboard');

});
Route::middleware(['auth', 'role:user'])->group(function () {
    
    Route::get('/dashboard_user', function () {
        return Inertia::render('Dashboard');
    })->name('user.dashboard');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
