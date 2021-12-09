<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Event;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

class EventsController extends Controller
{
    /**
     * Show the event.
     */
    public function show($id)
    {
        $event = Event::find($id);

        return view('events.show', ['event' => $event]);
    }

    /**
     * Return the available times as json.
     *
     * @param Request $request
     * @return false|string
     */
    public function getAvailableTimesJSON(Request $request)
    {

        $times = $this->getAvailableTimes($request->query('date'), $request->query('eventId'));

        return response()->json($times);
    }

    /**
     * Get the avaliable times for the event.
     */
    public function getAvailableTimes($date, $event_id = null): array
    {
        $times = [];

        $start_range = DateTime::createFromFormat("H:i", "00:00");
        $end_range = DateTime::createFromFormat("H:i", "24:00");
        $date_range = new DatePeriod($start_range, new DateInterval("PT30M"), $end_range);

        foreach ($date_range as $time) {
            $times[] = $time->format("H:i");
        }

        foreach (Event::where('start_date', $date)->where('id', '!=', $event_id)->get() as $event) {
            $start_time = Carbon::parse($event->start_time);
            $duration_count = $event->duration / 30;

            for ($i = 0; $i < $duration_count; $i++) {
                $key = array_search($start_time->addMinutes($i * 30)->format("H:i"), $times);

                if ($key != false) {
                    unset($times[$key]);
                }
            }
        }

        return $times;
    }

    /**
     * Return the create view.
     */
    public function create()
    {
        $times = $this->getAvailableTimes(Carbon::now()->format('Y-m-d'));

        return view('events.create', [
            'times' => $times,
            'timezones' => Helpers::timezonesList()
        ]);
    }

    /**
     * Create the event.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:events|max:255',
            'description' => 'required',
        ]);

        Event::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'start_time' => $request->input('start_times')[0],
            'duration' => count($request->input('start_times')) * 30,
            'timezone' => $request->input('timezone')
        ]);

        if ($request->cookie('timezone') == null) {
            Cookie::queue(cookie('timezone', $request->input('timezone'), $minute = 1440));
        }

        return redirect('/day');
    }

    /**
     * Return the edit view.
     */
    public function edit($id)
    {
        $event = Event::find($id);

        $timeslots = [];
        $start_time = Carbon::parse($event->start_time);
        $duration_count = $event->duration / 30;

        for ($i = 0; $i < $duration_count; $i++) {
            $timeslots[$i] = $start_time->addMinutes($i * 30)->format("H:i");
        }

        $times = $this->getAvailableTimes(Carbon::now()->format('Y-m-d'), $event->id);

        return view('events.edit', [
            'event' => $event,
            'times' => $times,
            'timeslots' => $timeslots,
            'timezones' => Helpers::timezonesList()]);
    }

    /**
     * Update the event.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:events|max:255',
            'description' => 'required',
        ]);

        $event = Event::find($id);

        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->start_time = $request->input('start_times')[0];
        $event->duration = count($request->input('start_times')) * 30;
        $event->timezone = $request->input('timezone');

        $event->save();

        return redirect('/day');
    }

    /**
     * Delete the event.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        $event->delete();

        return redirect('/day');
    }
}
