@extends('layout')

@section('title', __('Dashboard'))

@section('content')
    <x-card>
        <x-slot name="body">
            <p class="card-text">{{ __('Welcome to the dashboard.') }}</p>
        </x-slot>
    </x-card>
@endsection
