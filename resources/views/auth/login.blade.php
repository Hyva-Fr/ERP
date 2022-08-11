@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ route('login') }}">
            <h1 class="guest-title">{{ __(\Request::route()->getName()) }}</h1>
            @if (session('status'))
                <p class="partials">
                    {{ session('status') }}
                </p>
            @endif

            @if ($errors->any())
                <p class="partials error">{{ __('Whoops! Something went wrong.') }}</p>
                <ul class="partials errors-list">
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @csrf

            <div>
                <label for="guest-email" class="form-control">
                    <span>{{ __('Email') }}</span>
                    <input id="guest-email" type="email" name="email" value="{{ old('email') }}" required autofocus />
                </label>
            </div>

            <div>
                <label for="guest-password" class="form-control">
                    <span>{{ __('Password') }}</span>
                    <input id="guest-password" type="password" name="password" required autocomplete="current-password" />
                </label>
            </div>

            <div>
                <label for="guest-remember" class="form-control inline">
                    <input id="guest-remember" type="checkbox" name="remember" class="nude with-font">
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="options" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <div class="full">
                <button class="yellow auto" type="submit">
                   {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
@endsection
