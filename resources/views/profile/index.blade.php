@extends('layouts.template')

@section('content')
    <h1>
        <i class="fa-solid fa-user fa-lg fa-fw"></i>
        {{ __('My Profile') }}
    </h1>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
        @include('profile.update-profile-information-form')
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        @include('profile.update-password-form')
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        @include('profile.two-factor-authentication-form')
    @endif

    <div class="section full profile-container">
        <h3 class="step-title">{{ __('Roles') }}</h3>
        <div class="crud-checkbox form-control">
            @foreach($roles as $role)
                <label>
                    <input disabled class="with-font" value="{{ $role->id }}" type="checkbox" @if(in_array($role->id, $rolesIDs, true)) checked @endif">
                    <span>{{ $role->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
@endsection
