@extends('layouts.app')

@section('title', 'Day' )

@section('content')
    <div id="calendar"></div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridDay',
                events: '/planner/events',
                eventClick: function(info) {
                    if (info.event.url) {
                        window.open(info.event.url, "_blank");
                        return false;
                    }
                }
            });
            calendar.render();
        });
    </script>
@endsection
