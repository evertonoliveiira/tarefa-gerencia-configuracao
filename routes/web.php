<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/tarefas', [TarefaController::class, 'index'])->name('tarefas.index')->middleware('auth');
Route::post('/tarefas', [TarefaController::class, 'store'])->name('tarefas.store')->middleware('auth');
Route::put('/tarefas/{id}', [TarefaController::class, 'update'])->name('tarefas.update')->middleware('auth');
Route::delete('/tarefas/{id}', [TarefaController::class, 'destroy'])->name('tarefas.destroy')->middleware('auth');
Route::get('/tarefas/exportar-pdf', [TarefaController::class, 'exportarPdf'])->name('tarefas.exportar-pdf')->middleware('auth');
