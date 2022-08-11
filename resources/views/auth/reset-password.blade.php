@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <h1 class="guest-title">{{ __(getRouteFullName(\Request::route()->getName())) }}</h1>
            @if ($errors->any())
                <p class="partials error">{{ __('Whoops! Something went wrong.') }}</p>
                <ul class="partials errors-list">
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="guest-email" class="form-control">
                    <span>{{ __('Email') }}</span>
                    <input id="guest-email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
                </label>
            </div>

            <div>
                <label for="guest-password" class="form-control">
                    <span>{{ __('Password') }}</span>
                    <input id="guest-password" type="password" name="password" required autocomplete="new-password" />
                </label>
            </div>

            <div>
                <label for="guest-password_confirmation" class="form-control">
                    <span>{{ __('Confirm Password') }}</span>
                    <input id="guest-password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                </label>
            </div>

            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
