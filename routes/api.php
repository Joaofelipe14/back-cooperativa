<?php

use App\Http\Controllers\AuditoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistroFinanceiroController;
use App\Http\Controllers\LocalizacaoController;

use App\Http\Controllers\RegistroPescaController;
use App\Http\Controllers\RegistroVendaController;
use App\Http\Controllers\ResultadoMapaController;

Route::post('usuario/registrar', [UserController::class, 'register']);

Route::post('usuario/login', [UserController::class, 'login']);


Route::get('/version', function () {
    return response()->json([
        'version' =>  1.0
    ]);
});

Route::middleware('auth:sanctum')->group(function () {


    Route::get('/busca-usuarios', [UserController::class, 'getAll']);

    Route::post('/usuario/editar/{id}', [UserController::class, 'update']);
    Route::get('/usuario/me', [UserController::class, 'me']);

    /*Registro pesca*/
    Route::post('pesca', [RegistroPescaController::class, 'store']);
    Route::put('pesca/{id}', [RegistroPescaController::class, 'update']);
    Route::get('pesca/meus', [RegistroPescaController::class, 'getByUserId']);
    Route::get('pesca', [RegistroPescaController::class, 'getAll']);
    Route::post('pesca/relatorio-pesca', [RegistroPescaController::class,'gerarRelatorio']);



    /*Registro de venda*/
    Route::prefix('venda')->group(function () {
        Route::post('/', [RegistroVendaController::class, 'store']);
        Route::put('/{id}', [RegistroVendaController::class, 'update']);
        Route::get('/', [RegistroVendaController::class, 'getAll']);
        Route::get('/meus', [RegistroVendaController::class, 'getByUserId']);
        Route::post('/relatorio-pesca', [RegistroVendaController::class,'gerarRelatorio']);

    });

    /*Registro financeiro*/
    Route::get('financeiros', [RegistroFinanceiroController::class, 'index']);
    Route::post('financeiros', [RegistroFinanceiroController::class, 'store']);
    Route::get('financeiros/{id}', [RegistroFinanceiroController::class, 'show']);
    Route::put('financeiros/{id}', [RegistroFinanceiroController::class, 'update']);
    Route::delete('financeiros/{id}', [RegistroFinanceiroController::class, 'destroy']);
    Route::post('/financeiros/relatorio', [RegistroFinanceiroController::class, 'gerarPdf']);
    

    /*Localizações*/
    Route::apiResource('localizacoes', LocalizacaoController::class);

    /*Auditoria*/
    Route::get('busca-auditoria', [AuditoriaController::class,'getAll']);
    Route::get('tabelas-distintas', [AuditoriaController::class,'getTabelas']);

    /*ResultadoMapa*/
    Route::get('busca-resultado-mapa', [ResultadoMapaController::class,'getResultadoMapa']);
});



