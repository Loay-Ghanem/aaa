<?php

use App\Http\Controllers\api\ScriptController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/call', [ScriptController::class, 'callPythonScript']);
Route::get('/open', [ScriptController::class, 'open']);
Route::get('/close', [ScriptController::class, 'close']);
Route::get('/status', [ScriptController::class, 'status']);
