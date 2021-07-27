<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DespesasController;
use App\Http\Controllers\FileUploaderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('http://localhost:8000/sanctum/csrf-cookie')->name('auth.sanctum');

Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.user');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.user');
Route::post('/registrar', [LoginController::class, 'registrar']);
Route::post('/criarDespesa', [DespesasController::class, 'criarDespesa'])->name('new-desp');
Route::get('/getDespesas', [DespesasController::class, 'getDespesas']);
Route::put('/updateDespesa', [DespesasController::class, 'updateDespesa'])->name('update.desp');
Route::delete('/deletarDespesa/{id}', [DespesasController::class, 'deletarDespesa'])->name('del.desp');
Route::post('/uploadsFile', [FileUploaderController::class, 'handle']);
Route::post('/uploadsFileUpdate', [FileUploaderController::class, 'handleUpdate']);

Route::get('/test', function() {
    return auth()->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
