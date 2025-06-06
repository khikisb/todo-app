<?php
// Pastikan tidak ada spasi atau teks sebelum <?php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rute autentikasi Laravel
Auth::routes();

// Alihkan halaman utama ke daftar tugas
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');
});