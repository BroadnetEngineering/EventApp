<header class="d-flex px-5 flex-wrap align-items-center justify-content-center justify-content-md-between py-3  border-bottom">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <span><img height="25px" src="{{ asset('images/logo.png') }}"/></span>&nbsp;
        <span class="fs-4">Event App</span>
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/day" class="nav-link px-2 link-secondary">Day</a></li>
        <li><a href="/week" class="nav-link px-2 link-dark">Week</a></li>
        <li><a href="/month" class="nav-link px-2 link-dark">Month</a></li>
    </ul>

    <div class="col-md-3 text-end">
        <select class="form-select" name="timezone">
            @foreach(\App\Helpers::timezonesList() as $timezone)
                <option value="{{ $timezone }}">{{ $timezone }} </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 text-end">
        <a href="/events/create" class="btn btn-outline-primary me-2">Create Event</a>
    </div>
</header>
