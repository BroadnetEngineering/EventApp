@extends('layouts.app')

@section('title', 'Day' )

@section('content')
    <div id="calendar"></div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridDay'
            });
            calendar.render();
        });
    </script>
@endsection
