<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('empleado/area', [EmpleadoController::class, 'consultAreas']);
Route::get('empleado/rol', [EmpleadoController::class, 'consultRoles']);
Route::get('empleado/{id}/rol', [EmpleadoController::class, 'consultEmpleadoRoles']);
Route::resource('empleado', EmpleadoController::class);
