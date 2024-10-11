<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::apiResource('users', UserController::class); //create user
Route::apiResource('documents', DocumentController::class); // CRUD للمستندات
Route::apiResource('categories', CategoryController::class); // CRUD للفئات
Route::apiResource('roles', RoleController::class); // CRUD للأدوار
Route::apiResource('permissions', PermissionController::class); // CRUD للتصريحات