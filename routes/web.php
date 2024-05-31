<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

Route::get('/', [AppController::class, 'index'])->name('index');

Route::get('/eliminar/{id_gasto}', [AppController::class, 'eliminar'])->name('eliminar');

Route::post('/guardar/', [AppController::class, 'guardar'])->name('guardar');
Route::get('/guardar/', [AppController::class, 'index']);

Route::get('/editar/{id_gasto}', [AppController::class, 'editar'])->name('editar');