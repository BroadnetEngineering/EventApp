<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\PlannerController;
use Illuminate\Support\Facades\Route;

Route::get('/events/create', [EventsController::class, 'create']);
Route::get('/events/store', [EventsController::class, 'store']);
Route::get('/planner/day', [PlannerController::class, 'day']);
Route::get('/planner/week', [PlannerController::class, 'week']);
Route::get('/planner/month', [PlannerController::class, 'month']);
Route::get('/planner/events', [PlannerController::class, 'events']);
