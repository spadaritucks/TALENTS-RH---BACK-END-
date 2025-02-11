<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProcessosController;
use App\Http\Controllers\ProfissoesController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VagasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users', [UsersController::class, 'index']);
Route::post('/users', [UsersController::class, 'store']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);

Route::get('/profissoes', [ProfissoesController::class, 'index']);
Route::post('/profissoes', [ProfissoesController::class, 'store']);
Route::put('/profissoes/{id}', [ProfissoesController::class, 'update']);
Route::delete('/profissoes/{id}', [ProfissoesController::class, 'destroy']);

Route::get('/vagas', [VagasController::class, 'index']);
Route::post('/vagas', [VagasController::class, 'store']);
Route::put('/vagas/{id}', [VagasController::class, 'update']);
Route::delete('/vagas/{id}', [VagasController::class, 'destroy']);

Route::get('/processos', [ProcessosController::class, 'index']);
Route::post('/processos', [ProcessosController::class, 'store']);
Route::put('/processos/{id}', [ProcessosController::class, 'update']);
Route::delete('/processos/{id}', [ProcessosController::class, 'destroy']);

Route::get('/chamados', [ChamadoController::class, 'index']);
Route::post('/chamados', [ChamadoController::class, 'store']);
Route::put('/chamados/{id}', [ChamadoController::class, 'update']);
Route::delete('/chamados/{id}', [ChamadoController::class, 'destroy']);

Route::get('/atualizacoes', [ChamadoController::class, 'IndexAtualizacoes']);
Route::post('/atualizacoes', [ChamadoController::class, 'StoreAtualizacoes']);
Route::put('/atualizacoes/{id}', [ChamadoController::class, 'UpdateAtualizacoes']);
Route::delete('/atualizacoes/{id}', [ChamadoController::class, 'DestroyAtualizacoes']);



Route::post('/login', [LoginController::class, 'login']);


//Enviar Email
Route::post('/sendEmail', [SendEmailController::class, 'sendEmail']);

