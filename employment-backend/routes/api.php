<?php

use App\Http\Controllers\EmploymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('employments', EmploymentController::class);
Route::get('/employments', [EmploymentController::class, 'index']);
Route::get('/employments/count-by-category', [EmploymentController::class, 'countByCategory']);
Route::get('/employments/aggregation-by-date', [EmploymentController::class, 'aggregationByDate']);

Route::get('/employments/{id}', [EmploymentController::class, 'show']);
Route::post('/employments', [EmploymentController::class, 'store']);
Route::put('/employments/{id}', [EmploymentController::class, 'update']);
Route::delete('/employments/{id}', [EmploymentController::class, 'destroy']);