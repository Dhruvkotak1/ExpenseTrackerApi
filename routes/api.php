<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('profile',[AuthController::class,'profile'])->middleware('auth:sanctum');
Route::put('updatePassword',[AuthController::class,'updatePassword'])->middleware('auth:sanctum');
Route::post('forgotPassword',[AuthController::class,'forgotPassword']);
Route::post('resetPassword',[AuthController::class,'resetPassword'])->name("resetPassword");

Route::delete('user/deleteAccount',[AuthController::class,'deleteAccount'])->middleware('auth:sanctum');
Route::put('user/changeUsername',[AuthController::class,'changeUsername'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('expenses',ExpenseController::class); 
});

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('categories',CategoryController::class);
});

Route::get('reports/monthly',[ReportController::class,'monthly'])->middleware('auth:sanctum');
Route::get('reports/summary',[ReportController::class,'summary'])->middleware('auth:sanctum');
Route::get('reports/monthlyByCategory',[ReportController::class,'monthlyByCategory'])->middleware('auth:sanctum');








/**🧾 Expense Tracker API – Endpoint Overview
Group	Endpoint	Method	Description
🔐 Auth	/auth/register	POST	Register a new user
/auth/login	POST	Log in and get JWT token
/auth/logout	POST	Log out the current user (optional)
/auth/profile	GET	Get user profile info
/auth/update-password	PUT	Change user password
/auth/forgot-password	POST	Request password reset link
/auth/reset-password	POST	Reset password with token
🧾 Total Auth Endpoints		7 endpoints	

Group	Endpoint	Method	Description
💸 Expenses	/expenses	GET	List expenses (with filters)
/expenses	POST	Create a new expense
/expenses/{id}	GET	Get single expense by ID
/expenses/{id}	PUT	Update an existing expense
/expenses/{id}	DELETE	Delete an expense
🧾 Total Expense Endpoints		5 endpoints	

Group	Endpoint	Method	Description
🏷 Categories	/categories	GET	List all categories
/categories	POST	Create a new custom category
/categories/{id}	PUT	Update a category (optional)
/categories/{id}	DELETE	Delete a category (optional)
🧾 Total Category Endpoints		2–4 endpoints	

Group	Endpoint	Method	Description
📊 Reports	/reports/monthly	GET	Get summary of expenses by category
/reports/summary	GET	Get total income/expenses/balance
🧾 Total Report Endpoints		2 endpoints	

Group	Endpoint	Method	Description
👤 User	/users/settings	PUT	Update user settings/preferences
/users/delete-account	DELETE	Permanently delete user account
🧾 Total User Endpoints		2 endpoints	

✅ Total Summary
Section	Number of Endpoints
Auth	7
Expenses	5
Categories	2–4
Reports	2
User	2
TOTAL	18–20 endpoints */
