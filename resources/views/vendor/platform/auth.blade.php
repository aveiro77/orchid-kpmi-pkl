@extends('platform::app')

@section('body')
    <div class="container-md min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">
        <div class="w-100 px-3 px-sm-0" style="max-width: 440px;">

            {{-- Application Branding Header --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center p-3 bg-primary bg-opacity-10 text-primary rounded-circle mb-3">
                    <x-orchid-icon path="bs.shield-lock-fill" class="h1 mb-0" />
                </div>
                <h1 class="h3 fw-bold text-dark mb-1">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-muted small mb-0">{{ __('Sign in to access your dashboard') }}</p>
            </div>

            {{-- Auth Form Card --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-sm-5">
                    @yield('content')
                </div>
            </div>

            {{-- Application Branding Footer --}}
            <div class="mt-4 text-center text-muted small">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ __('All rights reserved.') }}</p>
            </div>

        </div>
    </div>
@endsection
