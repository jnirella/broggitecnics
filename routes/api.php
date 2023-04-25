<?php

use App\Http\Controllers\Api\CartaData;
use App\Http\Controllers\Api\CartaTrucadaController;
use App\Http\Controllers\Api\ExpedientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AgenciaController;
use App\Http\Controllers\Api\UsuariController;
use App\Http\Controllers\Api\EstatExpedientController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('agencies', AgenciaController::class);

Route::get('usuari-buscar', [UsuariController::class, 'buscar'])->name('usuari.buscar');
Route::apiResource('usuari', UsuariController::class);

// Route::get('expedients-carta-trucada', [ExpedientController::class, 'expedients_carta']);
Route::get('expedients-carta-trucada/{provincia?}/{comarca?}/{municipi?}', [ExpedientController::class, 'expedients_carta']);
Route::get('expedients/{filter}/{value?}/{dir?}', [ExpedientController::class, 'index']);
Route::get('expedient/{id}', [ExpedientController::class, 'show']);
Route::put('expedient/{id}', [ExpedientController::class, 'update']);

Route::apiResource('/estatExpedient', EstatExpedientController::class);

Route::apiResource('/cartesTrucades', CartaTrucadaController::class);

Route::get('/cartaData', [CartaData::class, 'index']);
Route::get('/interlocutorCheck/{number}', [CartaData::class, 'checkNumber']);
Route::get('/interlocutorGenerate', [CartaData::class, 'generateNumber']);