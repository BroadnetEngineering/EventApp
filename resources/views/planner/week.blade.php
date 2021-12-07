@extends('layouts.app')

@section('title', 'Week' )

@section('content')
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridWeek'
            });
            calendar.render();
        });
    </script>
@endsection
