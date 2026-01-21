<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ExpenseController; 
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/expenses', [ExpenseController::class, 'index']);
Route::post('/expenses', [ExpenseController::class, 'store']);
Route::put('/expenses/{id}', [ExpenseController::class, 'update']); 
Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy']); 