<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\AspectController; 
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Route yang membutuhkan Login
Route::middleware('auth')->group(function () {
    
    // Hak Akses GURU
    Route::middleware([CheckRole::class.':guru'])->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/scores/{student}/create', [ScoreController::class, 'create'])->name('scores.create');
        Route::post('/scores/{student}', [ScoreController::class, 'store'])->name('scores.store');
        Route::get('/descriptions/{student}/preview', [ScoreController::class, 'preview'])->name('scores.preview');
        Route::post('/descriptions/{student}/update', [ScoreController::class, 'updatePreview'])->name('scores.updatePreview');
        
        // Route Baru: Preview Raport per Semester
        Route::get('/students/{student}/raport/{semester}', [ScoreController::class, 'previewRaport'])->name('scores.previewRaport');

        Route::get('/aspects', [AspectController::class, 'index'])->name('aspects.index');
        Route::post('/aspects', [AspectController::class, 'store'])->name('aspects.store');
        Route::delete('/aspects/{aspect}', [AspectController::class, 'destroy'])->name('aspects.destroy');

        Route::post('/aspects/{aspect}/sub-indicators', [AspectController::class, 'storeSubIndicator'])->name('sub_indicators.store');
        Route::delete('/sub-indicators/{subIndicator}', [AspectController::class, 'destroySubIndicator'])->name('sub_indicators.destroy');
    });

    // Hak Akses MURID / ORANG TUA
    Route::middleware([CheckRole::class.':murid'])->group(function () {
        Route::get('/my-raport', [MuridController::class, 'myRaport'])->name('murid.raport');
        Route::get('/my-raport/pdf', [MuridController::class, 'exportPdf'])->name('murid.raport.pdf');
    });

});