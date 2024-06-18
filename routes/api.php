<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ModalidadesController;
use App\Http\Controllers\API\PlanosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/registrar', [AuthController::class, 'registrar'])->name('auth.registrar');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/modalidades', [ModalidadesController::class, 'index'])->name('modalidades.index');

Route::prefix('planos')->group(function () {
    Route::post('/criar', [PlanosController::class, 'criar'])->name('planos.criar');
    Route::get('/listar', [PlanosController::class, 'listar'])->name('planos.listar');
});
