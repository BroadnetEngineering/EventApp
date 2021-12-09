@extends('layouts.app')

@section('title', 'Edit Event' )

@section('content')
    <h3 class="text-center">Edit {{$event->name}}</h3>
    <div class="d-flex justify-content-center">
        <form method="POST" action="/events/{{$event->id}}" class="row w-50 g-3">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input value="{{$event->name}}" type="text" name="name" class="form-control" id="name">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description"
                          rows="3">{{$event->description}}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Start Date</label>
                <input type="text" class="form-control" name="start_date"
                       value="{{\Carbon\Carbon::parse($event->start_date)->format('m/d/y')}}"/>
            </div>
            <div class="col-md-12">
                <label class="form-label">Timeslots</label>
                <select multiple name="start_times[]" id="start-times">
                    @foreach($times as $time)
                        @if(in_array($time, $timeslots))
                            <option selected="selected"
                                    value="{{ $time }}">{{ \Carbon\Carbon::parse($time)->format("h:i a") }} </option>
                        @else
                            <option value="{{ $time }}">{{ \Carbon\Carbon::parse($time)->format("h:i a") }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Timezone</label>
                <select class="form-select" name="timezone">
                    @foreach($timezones as $timezone)
                        @if(array_search ($timezone, $timezones) == $event->timezone)
                            <option selected="selected"
                                    value="{{ array_search ($timezone, $timezones) }}">{{ $timezone }} </option>
                        @else
                            <option value="{{ array_search ($timezone, $timezones) }}">{{ $timezone }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Event</button>
            </div>
        </form>
    </div>

    <script>
        $(function () {
            $('input[name="start_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
            }, function (start) {
                $('input[name="start_date"]').val(start);

                $.ajax({
                    type: 'GET',
                    url: '/events/times?date=' + moment(start).format("MM/DD/YYYY") + "&eventId=" + {{$event->id}},
                    success: function (request) {
                        let data = JSON.parse(request);
                        let startTimes = $("#start-times");
                        startTimes.empty();
                        $.each(data, function (val, text) {
                            startTimes.append(
                                $('<option></option>').val(text).html(moment(text, "HH:mm:ss").format("hh:mm a"))
                            );
                        });
                    },
                    error: function () {
                        console.log(data);
                    }
                });
            });
        });

        new SlimSelect({
            select: '#start-times'
        })
    </script>
@endsection
