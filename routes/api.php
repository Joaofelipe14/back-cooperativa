<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistroFinanceiroController;
use App\Http\Controllers\RegistroPescaController;



Route::post('usuario/registrar', [UserController::class, 'register']);

Route::post('usuario/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {


    Route::post('/usuario/editar/{id}', [UserController::class, 'update']);
    Route::get('/usuario/me', [UserController::class, 'me']);

    /*Registro pesca*/

    Route::post('registros-pesca', [RegistroPescaController::class, 'store']);
    Route::put('registros-pesca/{id}', [RegistroPescaController::class, 'update']);
    Route::get('registros-pesca/user', [RegistroPescaController::class, 'getByUserId']);
    Route::get('registros-pesca', [RegistroPescaController::class, 'getAll']);

    /*Registro financeiro*/
    Route::get('registros-financeiros', [RegistroFinanceiroController::class, 'index']);
    Route::post('registros-financeiros', [RegistroFinanceiroController::class, 'store']);
    Route::get('registros-financeiros/{id}', [RegistroFinanceiroController::class, 'show']);
    Route::put('registros-financeiros/{id}', [RegistroFinanceiroController::class, 'update']);
    Route::delete('registros-financeiros/{id}', [RegistroFinanceiroController::class, 'destroy']);
});
