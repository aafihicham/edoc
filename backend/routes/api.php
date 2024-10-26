<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

// Publisher registration
Route::post('/register', [PublisherController::class, 'register']);

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Category routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Document routes
Route::post('/documents', [DocumentController::class, 'store']);
Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/documents/{id}', [DocumentController::class, 'show']);
Route::put('/documents/{id}', [DocumentController::class, 'update']);
Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);
Route::post('/documents/category/{categoryId}', [DocumentController::class, 'addToCategory']);

// Publisher routes
Route::get('/publishers', [PublisherController::class, 'index']);
Route::post('/publishers', [PublisherController::class, 'store']);
Route::get('/publishers/{id}', [PublisherController::class, 'show']);
Route::put('/publishers/{id}', [PublisherController::class, 'update']);
Route::delete('/publishers/{id}', [PublisherController::class, 'destroy']);


