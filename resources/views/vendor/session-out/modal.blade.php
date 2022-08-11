
@extends('modals.template')

@section('modal-title', __('Session expiration'))
@section('modal-content')
    <div class="modal-full">
        <p>
            {{ __('Your session will expire') }}.
        </p>
        <p>
            {{ __('To resume your current activity please click on the button') }}.
        </p>
        <div id="progress-bar"></div>
        <div class="modal-btns-container">
            <button class="yellow" onclick="closeSessionOutModal();" type="button" id="continue-session">{{ __('Continue') }}</button>
        </div>
    </div>
@endsection