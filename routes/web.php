<?php

use App\Http\Controllers\RegistroPescaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function (Request $request) {

    return response()->json(['status' => 'erro', 'message' => 'Sem autorização.'], 401);

})->name('login');


// Route::get('/relatorio', function () {
//     return view('pdf.relatorio');
// });
