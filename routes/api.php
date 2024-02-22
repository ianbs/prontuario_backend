<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacientesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::fallback(function () {
    return response()->json([
        'mensagem' => 'Página não encontrada.'
    ], 404);
});

Route::group(['prefix'=> 'v1'], function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::group(['prefix'=> 'pacientes'], function() {
        Route::get("/", [PacientesController::class, 'index']);
        Route::get("/{id}", [PacientesController::class, 'index']);
        Route::post("/", [PacientesController::class, 'store']);
        Route::put("/{id}", [PacientesController::class, 'update']);
        Route::delete("/{id}", [PacientesController::class, 'destroy']);
    });
});
