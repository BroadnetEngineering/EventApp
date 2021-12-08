<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\PlannerController;
use Illuminate\Support\Facades\Route;

Route::get('/events/{id}/delete', [EventsController::class, 'destroy'])->name('events.delete');
Route::resource('events', EventsController::class)->except(['index', 'destroy']);
Route::get('/', [PlannerController::class, 'day']);
Route::get('/day', [PlannerController::class, 'day']);
Route::get('week', [PlannerController::class, 'week']);
Route::get('/month', [PlannerController::class, 'month']);
Route::get('/planner/events', [PlannerController::class, 'events']);

