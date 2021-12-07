@extends('layouts.app')

@section('title', 'Create Event' )

@section('content')
    <h3 class="text-center">Create Event</h3>
    <div class="d-flex justify-content-center">
        <form action="/events/store"  class="row w-50 g-3">
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Start Date</label>
                <input type="text" class="form-control" name="start_date" value="" />
            </div>
            <div class="col-md-3">
                <label class="form-label">Start Time</label>
                <select class="form-select" name="start_time">
                        @foreach($dateRange as $date)
                            <option value="{{ $date->format("H:i") }}">{{ $date->format("h:i a") }} </option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Duration (min)</label>
                <select class="form-select" name="duration">
                    @foreach($durationRange as $duration)
                        <option value="{{ $duration }}">{{ $duration }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Timezone</label>
                <select class="form-select" name="timezone">
                    @foreach($timezones as $timezone)
                        <option value="{{ $timezone }}">{{ $timezone }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Create Event</button>
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
