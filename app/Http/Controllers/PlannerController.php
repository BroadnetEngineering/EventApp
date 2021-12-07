<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function day() {
        return view('planner.day');
    }

    public function week() {
        return view('planner.week');
    }

    public function month() {
        return view('planner.month');
    }
}
