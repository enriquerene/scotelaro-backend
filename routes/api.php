<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HorariosController;
use App\Http\Controllers\API\ModalidadesController;
use App\Http\Controllers\API\PlanosController;
use App\Http\Controllers\API\TurmasController;
use App\Http\Controllers\API\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/registrar', [AuthController::class, 'registrar'])->name('auth.registrar');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::prefix('modalidades')->group(function () {
    Route::get('/', [ModalidadesController::class, 'listar'])->name('modalidades.listar');
    Route::post('/criar', [ModalidadesController::class, 'criar'])->name('modalidades.criar');
    Route::post('/{id}/imagem', [ModalidadesController::class, 'defineImagem'])->name('modalidades.imagem');
    Route::post('/{id}/atualizar', [ModalidadesController::class, 'atualizar'])->name('modalidades.atualizar');
});

Route::prefix('horarios')->group(function () {
    Route::get('/', [HorariosController::class, 'listar'])->name('horarios.listar');
    Route::post('/criar', [HorariosController::class, 'criar'])->name('horarios.criar');
});

Route::prefix('turmas')->group(function () {
    Route::get('/', [TurmasController::class, 'listar'])->name('turmas.listar');
    Route::post('/criar', [TurmasController::class, 'criar'])->name('turmas.criar');
});

Route::prefix('planos')->group(function () {
    Route::get('/', [PlanosController::class, 'listar'])->name('planos.listar');
    Route::post('/criar', [PlanosController::class, 'criar'])->name('planos.criar');
});

Route::prefix('usuarios')->middleware('auth.utoken')->group(function () {
    Route::post('plano/inscrever', [UsuariosController::class, 'inscricaoEmPlano'])->name('usuario.plano.inscrever');
    Route::post('plano/cancelar', [UsuariosController::class, 'cancelarPlano'])->name('usuario.plano.cancelar');
    Route::post('turma/{id}/experimentar')->name('usuario.turma.experimentar');
});
