@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h1 class="guest-title">{{ __(\Request::route()->getName()) }}</h1>
            @if ($errors->any())
                <p class="partials error">{{ __('Whoops! Something went wrong.') }}</p>
                <ul class="partials errors-list">
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div>
                <label for="guest-firstname" class="form-control">
                    <span>{{ __('Firstname') }}</span>
                    <input id="guest-firstname" type="text" name="firstname" value="{{ old('firstname') }}" required autofocus autocomplete="firstname" />
                </label>
            </div>

            <div>
                <label for="guest-lastname" class="form-control">
                    <span>{{ __('Lastname') }}</span>
                    <input id="guest-lastname" type="text" name="lastname" value="{{ old('lastname') }}" required autofocus autocomplete="lastname" />
                </label>
            </div>

            <div>
                <label for="guest-email" class="form-control">
                    <span>{{ __('Email') }}</span>
                    <input id="guest-email" type="email" name="email" value="{{ old('email') }}" required />
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

            <a class="options" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
@endsection
