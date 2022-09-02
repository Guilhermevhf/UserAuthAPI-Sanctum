<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/ping', function(){
    return [ 'pong' => True ];
});

Route::post('/unauthenticated', function(){
    return ['error' => 'Usuário não logado!'];
})->name('login');

Route::middleware('auth:sanctum')->post('/todo', [ApiController::class, 'createTodo']);
Route::get('/todos', [ApiController::class, 'readAllTodos']);
Route::get('/todo/{id}', [ApiController::class, 'readTodo']);
Route::put('/todo/{id}', [ApiController::class, 'updateTodo']);
Route::delete('/todo/{id}', [ApiController::class, 'deleteTodo']);  

Route::post('/user', [AuthController::class, 'create']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth', [AuthController::class, 'login']);