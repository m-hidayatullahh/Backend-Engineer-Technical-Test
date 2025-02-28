<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

// Endpoint untuk mendapatkan daftar users
Route::get('/users', [UserController::class, 'index']);

// Endpoint untuk mendapatkan daftar barang (items)
Route::get('/items', [ItemController::class, 'index']);

// Endpoint untuk request barang
Route::get('/requests', [RequestController::class, 'index']);
Route::post('/requests', [RequestController::class, 'store']);

Route::get('/users/nik/{nik}', [UserController::class, 'findByNik']);

Route::put('/requests/{id}/update-status', [RequestController::class, 'updateStatus']);

