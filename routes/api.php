<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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


// API Users
Route::get('/getUsers', [UserController::class, 'getUsers']);
Route::get('/getUsersById/{id}', [UserController::class, 'show']);
Route::post('/createUser', [UserController::class, 'store']);
Route::delete('/deleteUser/{id}', [UserController::class, 'destroy']);
Route::put('/updateUser/{id}', [UserController::class, 'update']);
Route::put('/updateStatus/{id}', [UserController::class, 'updateStatus']);
Route::get('/getRolesSelect', [UserController::class, 'getRolesSelect']);

// API Roles
Route::get('/getRoles', [RoleController::class, 'getRoles']);
Route::post('/createRol', [RoleController::class, 'store']);
Route::put('/updateRol/{id}', [RoleController::class, 'update']);
Route::delete('/deleteRol/{id}', [RoleController::class, 'destroy']);
