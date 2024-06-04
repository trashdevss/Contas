<?php

use App\Http\Controllers\ContaController;
use App\Http\Controllers\ProfileController;
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


// CONTAS
Route::get('/', function () {
    return view('auth/register');
});
Route::middleware('conta')->group(function () {
    Route::get('/index-conta', [ContaController::class, 'index'])->name('conta.index');
    Route::get('/create-conta', [ContaController::class, 'create'])->name('conta.create');
    Route::post('/store-conta', [ContaController::class, 'store'])->name('conta.store');
    Route::get('/show-conta/{conta}', [ContaController::class, 'show'])->name('conta.show');
    Route::get('/edit-conta/{conta}', [ContaController::class, 'edit'])->name('conta.edit');
    Route::put('/update-conta/{conta}', [ContaController::class, 'update'])->name('conta.update');
    Route::delete('/destroy-conta/{conta}', [ContaController::class, 'destroy'])->name('conta.destroy');
    Route::post('/restore-conta', [ContaController::class, 'restore'])->name('conta.restore');
    Route::get('/change-situation-conta/{conta}', [ContaController::class, 'changeSituation'])->name('conta.change-situation');
    Route::get('/gerar-pdf-conta', [ContaController::class, 'gerarPdf'])->name('conta.gerar-pdf');
    Route::get('/gerar-csv-conta', [ContaController::class, 'gerarCsv'])->name('conta.gerar-csv');
    Route::get('/gerar-word-conta', [ContaController::class, 'gerarWord'])->name('conta.gerar-word');
});

// AUTH
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';
