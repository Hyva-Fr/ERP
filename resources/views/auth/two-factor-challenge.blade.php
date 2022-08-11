@extends('layouts.app')

@section('content')
    <div id="guest-container">
        {!! svg('hyva', 'guest-icon') !!}

        <form method="POST" action="{{ url('/two-factor-challenge') }}">
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

            <div class="recovery-code-container" id="authenticate-with-app">
                <p class="partials">
                    {!! __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') !!}
                </p>

                <div>
                    <label for="guest-code" class="form-control">
                        <span>{{ __('Code') }}</span>
                        <input id="guest-code" type="text" name="code" autofocus autocomplete="one-time-code" />
                    </label>
                </div>
                <small class="choose-recovery options" data-choice="authenticate-with-emergency">Access with emergency recovery codes</small>
            </div>

            <div class="recovery-code-container hidden" id="authenticate-with-emergency">
                <p class="partials">
                    {!! __('Please confirm access to your account by entering one of your emergency recovery codes.') !!}
                </p>

                <div>
                    <label for="guest-recovery_code" class="form-control">
                        <span>{{ __('Recovery Code') }}</span>
                        <input id="guest-recovery_code" type="text" name="recovery_code" autocomplete="one-time-code" />
                    </label>
                </div>
                <small class="choose-recovery options" data-choice="authenticate-with-app">Access with authenticator application</small>
            </div>

            <div class="full">
                <button class="yellow auto" type="submit">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
@endsection
