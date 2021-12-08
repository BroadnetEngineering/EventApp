@extends('layouts.app')

@section('title', 'Create Event' )

@section('content')
    <h3 class="text-center">Create Event</h3>
    <div class="d-flex justify-content-center">
        <form method="POST" action="/events" class="row w-50 g-3">
            @csrf
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="start_date" value=""/>
            </div>
            <div class="col-md-12">
                <label class="form-label">Timeslots</label>
                <select multiple class="" id="start-times" name="start_times[]">
                    @foreach($times as $time)
                        <option value="{{ $time }}">{{ \Carbon\Carbon::parse($time)->format("h:i a") }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Timezone</label>
                <select class="form-select" name="timezone">
                    @foreach($timezones as $timezone)
                        @if(Illuminate\Support\Facades\Cookie::get('timezone') == array_search ($timezone, $timezones))
                            <option selected="selected"
                                    value="{{ array_search ($timezone, $timezones) }}">{{ $timezone }} </option>
                        @else
                            <option value="{{ array_search ($timezone, $timezones) }}">{{ $timezone }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Create Event</button>
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
                    url: '/events/times?date=' + moment(start).format("MM/DD/YYYY"),
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
