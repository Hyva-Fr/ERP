@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ route('password.confirm') }}">
            <h1 class="guest-title">{{ __(getRouteFullName(\Request::route()->getName())) }}</h1>
            @csrf

            @if ($errors->any())
                <p class="partials error">{{ __('Whoops! Something went wrong.') }}</p>
                <ul class="partials errors-list">
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            
            <div>
                <label for="guest-password" class="form-control">
                    <span>{{ __('Password') }}</span>
                    <input id="guest-password" type="password" name="password" required autocomplete="current-password" />
                </label>
            </div>

            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Confirm Password') }}
                </button>
            </div>

            @if (Route::has('password.request'))
                <a class="options" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
@endsection
