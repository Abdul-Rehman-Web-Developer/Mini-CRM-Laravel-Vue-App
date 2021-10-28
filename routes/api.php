<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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

Route::resource('employees', EmployeeController::class);
Route::resource('companies', CompanyController::class);

Route::middleware('auth:sanctum')->get('/user', function(Request $request){
	return $request->user();
});

// update company logo
Route::post('/companies/update_logo', [CompanyController::class, 'updateLogo']);

// on login
Route::post('/login', [AuthController::class, 'login']);

// on logout
Route::get('/logout', [AuthController::class, 'logout']);



