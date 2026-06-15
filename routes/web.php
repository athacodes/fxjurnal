<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SignalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/signals', [SignalController::class, 'index'])->name('admin.signals.index');
    Route::post('/admin/signals/store', [SignalController::class, 'store'])->name('admin.signals.store');

    Route::get('/member/signals', [SignalController::class, 'index'])->name('member.signals');

    Route::get('/notes', [NoteController::class, 'indexNotes'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'createNote'])->name('notes.create');
    Route::post('/notes/store', [NoteController::class, 'storeNote'])->name('notes.store');
    Route::get('/notes/show/{id}', [NoteController::class, 'showNote'])->name('notes.show');
    Route::get('/notes/edit/{id}', [NoteController::class, 'editNote'])->name('notes.edit');
    Route::put('/notes/update/{id}', [NoteController::class, 'updateNote'])->name('notes.update');
    Route::delete('/notes/delete/{id}', [NoteController::class, 'deleteNote'])->name('notes.destroy');

    Route::get('/uploads/download/{id}', 'App\Http\Controllers\UploadController@downloadFile')->name('uploads.download');
});
