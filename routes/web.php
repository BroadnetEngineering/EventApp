<?php

use App\Http\Controllers\PlannerController;
use Illuminate\Support\Facades\Route;

Route::get('/planner/day', [PlannerController::class, 'day']);
Route::get('/planner/week', [PlannerController::class, 'week']);
Route::get('/planner/month', [PlannerController::class, 'month']);
