<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;



// -- Products
Route::get('/products', [ProductController::class, 'index']);

Route::post('/products123', [ProductController::class, 'store']);


// -- Employee
Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee123', [EmployeeController::class, 'store']);