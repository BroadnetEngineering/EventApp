@extends('layouts.app')

@section('title', 'Edit Event' )

@section('content')
    <h3 class="text-center">Edit {{$event->name}}</h3>
    <div class="d-flex justify-content-center">
        <form method="PUT" action="/events/{{$event->id}}"  class="row w-50 g-3">
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input value="{{$event->name}}" type="text" name="name" class="form-control" id="name">
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3">{{$event->description}}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Start Date</label>
                <input type="text" class="form-control" name="start_date" value="{{\Carbon\Carbon::parse($event->start_date)->format('m/d/y')}}" />
            </div>
            <div class="col-md-3">
                <label class="form-label">Start Time</label>
                <select class="form-select" name="start_time">
                        @foreach($date_range as $date)
                            @if($date->format("H:i") == \Carbon\Carbon::parse($event->start_time)->format('H:i'))
                                <option selected="selected" value="{{ $date->format("H:i") }}">{{ $date->format("h:i a") }} </option>
                            @else
                                <option value="{{ $date->format("H:i") }}">{{ $date->format("h:i a") }} </option>
                            @endif
                        @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Duration (min)</label>
                <select class="form-select" name="duration">
                    @foreach($duration_range as $duration)
                        @if($duration == $event->duration)
                            <option selected="selected" value="{{ $duration }}">{{ $duration }} </option>
                        @else
                            <option value="{{ $duration }}">{{ $duration }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Timezone</label>
                <select class="form-select" name="timezone">
                    @foreach($timezones as $timezone)
                        @if(array_search ($timezone, $timezones) == $event->timezone)
                            <option selected="selected" value="{{ array_search ($timezone, $timezones) }}">{{ $timezone }} </option>
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
        $(function() {
            $('input[name="start_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
            }, function(start) {
                $('input[name="start_date"]').val(start);
            });
        });
    </script>
@endsection
