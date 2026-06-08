<?php

use App\Http\Controllers\Admin\ExerciseLibraryController;
use App\Http\Controllers\Admin\MasterMenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ฤฤ Library System: Admin Only ฤฤ
Route::middleware(['auth', 'role:system-admin|sub-admin'])->prefix('admin')->name('admin.')->group(function () {
    // คลังท่าออกกำลังกาย
    Route::resource('exercise-libraries', ExerciseLibraryController::class);
    Route::post('exercise-libraries/{exerciseLibrary}/toggle-active', [ExerciseLibraryController::class, 'toggleActive'])->name('exercise-libraries.toggle-active');

    // จัดการเมนูอาหาร
    Route::resource('master-menus', MasterMenuController::class);
    Route::post('master-menus/{masterMenu}/toggle-active', [MasterMenuController::class, 'toggleActive'])->name('master-menus.toggle-active');
});

require __DIR__.'/auth.php';