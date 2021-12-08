<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Event;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventsController extends Controller
{
    public function show($id)
    {
        $event = Event::find($id);

        return view('events.show', ['event' => $event]);
    }

    public function create()
    {
        $start_range = DateTime::createFromFormat("H:i", "00:00");
        $end_range = DateTime::createFromFormat("H:i", "24:00");
        $date_range = new DatePeriod($start_range, new DateInterval("PT30M"), $end_range );

        $duration_range = range(30, 720, 30);

        return view('events.create', [
            'date_range' => $date_range,
            'duration_range' => $duration_range,
            'timezones' => Helpers::timezonesList()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:posts|max:255',
            'description' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'duration' => 'required',
            'timezone' => 'required'
        ]);

        Event::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'start_time' => $request->input('start_time'),
            'duration' => $request->input('duration'),
            'timezone' => $request->input('timezone')
        ]);

        return redirect('/day');
    }

    public function edit($id)
    {
        $event = Event::find($id);

        $start_range = DateTime::createFromFormat("H:i", "00:00");
        $end_range = DateTime::createFromFormat("H:i", "24:00");
        $date_range = new DatePeriod($start_range, new DateInterval("PT30M"), $end_range );

        $duration_range = range(30, 720, 30);

        return view('events.edit', [
            'event' => $event,
            'date_range' => $date_range,
            'duration_range'=> $duration_range,
            'timezones' => Helpers::timezonesList()])
            ;
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->name = $request->input('name');
        $event->description = $request->input('description');

        $event->save();

        return redirect('/day');
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        $event->delete();

        return redirect('/day');
    }
}
