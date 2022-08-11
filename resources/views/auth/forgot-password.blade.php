@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ route('password.email') }}">
            <h1 class="guest-title">{{ __(getRouteFullName(\Request::route()->getName())) }}</h1>
            @csrf

            <p class="partials">
                {!! __('Forgot your password?<br>No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') !!}
            </p>

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

            <div>
                <label for="guest-email" class="form-control">
                    <span>{{ __('Email') }}</span>
                    <input id="guest-email" type="email" name="email" value="{{ old('email') }}" required autofocus />
                </label>
            </div>

            <a class="options" href="{{ route('login') }}">
                {{ __('Back to login page') }}
            </a>

            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
@endsection
