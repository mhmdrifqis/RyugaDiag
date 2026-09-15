<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\KerusakanController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\TeknisiController;
use App\Http\Controllers\Teknisi\DashboardController as TeknisiDashboard;
use App\Http\Controllers\Teknisi\DiagnosaController;
use App\Http\Controllers\Teknisi\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Common authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Role-based redirection
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('teknisi.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    Route::post('gejala/import', [GejalaController::class, 'import'])->name('gejala.import');
    Route::resource('gejala', GejalaController::class);
    
    Route::post('kerusakan/import', [KerusakanController::class, 'import'])->name('kerusakan.import');
    Route::resource('kerusakan', KerusakanController::class);
    
    Route::post('rule/import', [RuleController::class, 'import'])->name('rule.import');
    Route::resource('rule', RuleController::class);
    
    Route::resource('teknisi', TeknisiController::class);
});

// Teknisi Routes
Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/dashboard', [TeknisiDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/diagnosa/create', [DiagnosaController::class, 'create'])->name('diagnosa.create');
    Route::post('/diagnosa/proses', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');
    Route::get('/diagnosa/{id}/hasil', [DiagnosaController::class, 'hasil'])->name('diagnosa.hasil');
    
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
});

require __DIR__.'/auth.php';
