<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ConsultoresController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\HeadhuntersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProcessosController;
use App\Http\Controllers\ProfissoesController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\VagasController;
use App\Http\Controllers\ChamadoAtualizacoesController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('candidatos')->group(function () {
    Route::get('/', [CandidatosController::class, 'getCandidatos']);
    Route::get('/{id}', [CandidatosController::class, 'getCandidatoById']);
    Route::post('/', [CandidatosController::class, 'createCandidato']);
    Route::patch('/{id}', [CandidatosController::class, 'updateCandidato']);
    Route::delete('/{id}', [CandidatosController::class, 'deleteCandidato']);
});

Route::prefix('headhunters')->group(function () {
    Route::get('/', [HeadhuntersController::class, 'getHeadhunters']);
    Route::get('/{id}', [HeadhuntersController::class, 'getHeadhunterById']);
    Route::post('/', [HeadhuntersController::class, 'createHeadhunter']);
    Route::patch('/{id}', [HeadhuntersController::class, 'updateHeadhunter']);
    Route::delete('/{id}', [HeadhuntersController::class, 'deleteHeadhunter']);
});

Route::prefix('empresas')->group(function () {
    Route::get('/', [EmpresasController::class, 'getEmpresas']);
    Route::get('/{id}', [EmpresasController::class, 'getEmpresaById']);
    Route::post('/', [EmpresasController::class, 'createEmpresa']);
    Route::patch('/{id}', [EmpresasController::class, 'updateEmpresa']);
    Route::delete('/{id}', [EmpresasController::class, 'deleteEmpresa']);
});

Route::prefix('admins')->group(function () {
    Route::get('/', [AdminsController::class, 'getAdmins']);
    Route::get('/{id}', [AdminsController::class, 'getAdminById']);
    Route::post('/', [AdminsController::class, 'createAdmin']);
    Route::patch('/{id}', [AdminsController::class, 'updateAdmin']);
    Route::delete('/{id}', [AdminsController::class, 'deleteAdmin']);
});


Route::prefix('consultores')->group(function () {
    Route::get('/', [ConsultoresController::class, 'getConsultores']);
    Route::get('/{id}', [ConsultoresController::class, 'getConsultorById']);
    Route::post('/', [ConsultoresController::class, 'createConsultor']);
    Route::patch('/{id}', [ConsultoresController::class, 'updateConsultor']);
    Route::delete('/{id}', [ConsultoresController::class, 'deleteConsultor']);
});

Route::prefix('vagas')->group(function () {
    Route::get('/', [VagasController::class, 'getVagas']);
    Route::get('/{id}', [VagasController::class, 'getVagaById']);
    Route::post('/', [VagasController::class, 'createVaga']);
    Route::patch('/{id}', [VagasController::class, 'updateVaga']);
    Route::delete('/{id}', [VagasController::class, 'deleteVaga']);
});

Route::prefix('processos')->group(function () {
    Route::get('/', [ProcessosController::class, 'getProcessos']);
    Route::get('/{id}', [ProcessosController::class, 'getProcessoById']);
    Route::post('/', [ProcessosController::class, 'createProcesso']);
    Route::patch('/{id}', [ProcessosController::class, 'updateProcesso']);
    Route::delete('/{id}', [ProcessosController::class, 'deleteProcesso']);
});

Route::prefix('chamados')->group(function () {
    Route::get('/', [ChamadoController::class, 'getChamados']);
    Route::get('/{id}', [ChamadoController::class, 'getChamadoById']);
    Route::post('/', [ChamadoController::class, 'createChamado']);
    Route::patch('/{id}', [ChamadoController::class, 'updateChamado']);
    Route::delete('/{id}', [ChamadoController::class, 'deleteChamado']);
});

Route::prefix('profissoes')->group(function () {
    Route::get('/', [ProfissoesController::class, 'getProfissoes']);
    Route::get('/{id}', [ProfissoesController::class, 'getProfissaoById']);
    Route::post('/', [ProfissoesController::class, 'createProfissao']);
    Route::patch('/{id}', [ProfissoesController::class, 'updateProfissao']);
    Route::delete('/{id}', [ProfissoesController::class, 'deleteProfissao']);
});

Route::prefix('atualizacoes')->group(function () {
    Route::get('/', [ChamadoAtualizacoesController::class, 'getAtualizacoes']);
    Route::get('/{id}', [ChamadoAtualizacoesController::class, 'getAtualizacaoById']);
    Route::post('/', [ChamadoAtualizacoesController::class, 'createAtualizacao']);
    Route::patch('/{id}', [ChamadoAtualizacoesController::class, 'updateAtualizacao']);
    Route::delete('/{id}', [ChamadoAtualizacoesController::class, 'deleteAtualizacao']);
});


Route::get('/users', [UsersController::class, 'getAllUsers']);
Route::post('/login', [LoginController::class, 'login']);

//Enviar Email
Route::post('/sendEmail', [SendEmailController::class, 'sendEmail']);


