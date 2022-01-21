@extends('layout')

@section('title', __('Login'))

@section('content')
    <div class="mx-auto" style="max-width: 21.875rem;">
        <x-card>
            <x-slot name="header">{{ __('Pfizer network login') }}</x-slot>
            <x-slot name="body">
                <p class="card-text small text-center">{{ __('Sign in with one click if logged in to the Pfizer network.') }}</p>
                <x-link-button full-width href="{{ config('cognito.endpoint') }}/authorize?client_id={{ config('cognito.client_id') }}&grant_type={{ config('cognito.grant_type') }}&redirect_uri={{ config('cognito.redirect_uri') }}&response_type=code" primary>{{ __('Pfizer network login') }}</x-link-button>
            </x-slot>
        </x-card>
        @env('local', 'staging')
            <x-card class="mt-3">
                <x-slot name="header">{{ __(':Environment login', ['environment' => app()->environment()]) }}</x-slot>
                <x-slot name="body">
                    <x-form :action="route('login')" method="POST">
                        <x-form-group>
                            <x-floating-label-input autocomplete="email" :label="__('Email')" name="email" required type="email" :value="old('email')" />
                        </x-form-group>
                        <x-form-group>
                            <x-floating-label-input autocomplete="current-password" :label="__('Password')" name="password" required type="password" />
                        </x-form-group>
                        <x-form-group>
                            <x-checkbox :checked="old('remember')" name="remember">{{ __('Remember me on this device') }}</x-checkbox>
                        </x-form-group>
                        <x-form-group last>
                            <x-button full-width primary type="submit">{{ __('Login') }}</x-button>
                        </x-form-group>
                    </x-form>
                </x-slot>
            </x-card>
        @endenv
    </div>
@endsection
