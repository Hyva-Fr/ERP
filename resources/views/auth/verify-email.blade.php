@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <h1 class="guest-title">{{ __(getRouteFullName(\Request::route()->getName())) }}</h1>
            <p class="partials">
                {!! __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') !!}
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="partials">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </p>
            @endif

            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form class="full logout" method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Logout') }}
                </button>
            </div>
        </form>
    </div>
@endsection
