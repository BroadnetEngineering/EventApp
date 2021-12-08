@extends('layouts.app')

@section('title', 'Show Event' )

@section('content')
    <div class="row">
        <div class="col">
        </div>
        <div class="col text-center">
            <h3>{{$event->name}}</h3>
            <p class="pt-2">{{$event->description}}</p>
        </div>
        <div class="col text-end">
            <a class="text-dark" href="/events/{{$event->id}}/edit"><svg height="25px" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg></a>
            <a class="text-dark" href="{{ route('events.delete',$event->id) }}">
            <svg height="25px" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg></a>
        </div>
    </div>
@endsection
