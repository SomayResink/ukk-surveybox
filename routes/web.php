<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard default - PERBAIKAN
Route::get('/dashboard', function () {
    // Gunakan Auth::user() bukan auth()->user()
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->role === 'student') {
        return redirect()->route('student.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'super_admin') {
        return redirect()->route('superadmin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile routes (dari Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Student Routes
Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('history', [StudentController::class, 'history'])->name('student.history');
    Route::post('complaint', [StudentController::class, 'storeComplaint'])->name('student.complaint.store');
});
// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('history', [AdminController::class, 'history'])->name('admin.history');  // Tambah ini
    Route::post('feedback/{complaint}', [AdminController::class, 'sendFeedback'])->name('admin.feedback.send');
    Route::get('complaint/{complaint}', [AdminController::class, 'showComplaint'])->name('admin.complaint.show');
});

Route::middleware(['auth'])->prefix('superadmin')->group(function () {
    Route::get('dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::post('create-admin', [SuperAdminController::class, 'createAdmin'])->name('superadmin.create-admin');
    Route::post('create-category', [SuperAdminController::class, 'createCategory'])->name('superadmin.create-category');
    Route::get('complaints', [SuperAdminController::class, 'allComplaints'])->name('superadmin.complaints');
    Route::delete('admin/{admin}', [SuperAdminController::class, 'deleteAdmin'])->name('superadmin.delete-admin');
});

require __DIR__.'/auth.php';
