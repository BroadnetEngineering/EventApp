<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PlannerController extends Controller
{
    /**
     * Return a list of events.
     */
    public function events()
    {
        $timezone = Cookie::get('timezone');

        $events = Event::all();

        $calendar_events = [];

        foreach ($events as $event) {
            $event_time = explode(':', $event->start_time);

            $start_time = $event->start_date
                ->addHours($event_time[0])
                ->addMinutes($event_time[1])
                ->shiftTimezone($event->timezone);

            $calendar_events[] = [
                'title' => $event->name,
                'url' => 'events/' . $event->id,
                'start' => Carbon::parse($start_time)
                    ->timezone($timezone)
                    ->format('Y-m-d H:i'),
                'end' => Carbon::parse($start_time)
                    ->timezone($timezone)
                    ->addMinutes($event->duration)
                    ->format('Y-m-d H:i'),
                'color' => '#FF5722'
            ];

        }

        return response()->json($calendar_events);
    }

    /**
     * Add the timezone to the cache.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setTimezone(Request $request)
    {
        Cookie::queue(cookie('timezone', $request->input('timezone'), $minute = 1440));
        return redirect('/day');
    }

    /**
     * Return the day view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function day()
    {
        return view('planner.day');
    }

    /**
     * Return the week view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function week()
    {
        return view('planner.week');
    }

    /**
     * Return the month view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function month()
    {
        return view('planner.month');
    }
}
