<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;


Route::get('/', fn () => null);

// Login/Logout =======================================================
Route::post('/login', [Controllers\LoginController::class, 'store']);
Route::post('/logout', [Controllers\LoginController::class, 'destroy']);


// TODO: Password Reset =====================================================
Route::post('/password/forgot', Controllers\Password\ForgotPasswordController::class);
Route::post('/password/reset', Controllers\Password\ResetPasswordController::class);


// Authenticated ============================================================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', Controllers\LoggedInController::class);
    Route::put('/user', Controllers\UpdateAccountDetailsController::class);
    Route::put('/user/password', Controllers\UpdatePasswordController::class);
});

// Authenticated + isAdmin ============================================================
Route::middleware(['auth:sanctum', 'isadmin'])->group(function () {
    Route::get('/dashboard', Controllers\AdminDashboardController::class);
    
    // Companies
    Route::get('/companies', [Controllers\CompanyController::class, 'index']);
    Route::get('/companies/{id}', [Controllers\CompanyController::class, 'show']);
    Route::post('/companies/add', [Controllers\CompanyController::class, 'store']);
    Route::put('/companies/{company}', [Controllers\CompanyController::class, 'update']);

    // Employees
    Route::get('/employees/{id}', [Controllers\EmployeeController::class, 'show']);
    Route::post('/employees/add', [Controllers\EmployeeController::class, 'store']);
    Route::put('/employees/{employee}', [Controllers\EmployeeController::class, 'update']);
    Route::delete('/employees/{employee}', [Controllers\EmployeeController::class, 'destroy']);

    // Users
    Route::get('/users', [Controllers\UserController::class, 'index']);
    
});