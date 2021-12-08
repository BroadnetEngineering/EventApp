<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function events()
    {
        $events = Event::all();

        $calendar_events = [];

        foreach($events as $event)
        {
            $event_time = explode(':', $event->start_time);
            $start_time = $event->start_date->addHours($event_time[0])->addMinutes($event_time[1]);

            $calendar_events[] = [
                'title' => $event->name,
                'url' => 'events/'.$event->id,
                'start' => $start_time->format('Y-m-d H:i'),
                'end' => $start_time->addMinutes($event->duration)->format('Y-m-d H:i'),
                'color' => '#FF5722'
            ];

        }

        return $calendar_events;
    }

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
