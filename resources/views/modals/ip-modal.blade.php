@extends('modals.template')

@section('modal-title', __('IP Details'))
@section('modal-content')
    <div class="two-sides-modal" data-id="{{ $data['id'] }}">
        <div class="modal-left modal-sides" data-lat="{{ $data['latitude'] }}" data-lng="{{ $data['longitude'] }}">
            <div id="map"></div>
            <div class="modal-btns-container">
                <button class="yellow" type="button" id="unban-ip">{{ __('Unban IP') }}</button>
            </div>
        </div>
        <div class="modal-right modal-sides">
            <p>
                IP:&nbsp;<span>{{ $data['ip'] }}</span>
            </p>
            <p>
                Last attempt:&nbsp;
                <span>
                    @if($data['updated_at'] !== null)
                        {{ $data['updated_at'] }}
                    @else
                        {{ $data['created_at'] }}
                    @endif
                </span>
            </p>
            <p>
                {{ __('Status') }}:&nbsp;
                <span>
                    {{ $data['attempts'] }} @if($data['attempts'] > 1) {{ __('attempts') }} @else {{ __('attempt') }} @endif
                    @if($data['is_ban'] === 0)
                        <i class="fa-solid fa-lock-open fa-lg fa-fw blue"></i>
                    @else
                        <i class="fa-solid fa-lock fa-lg fa-fw red"></i>
                    @endif
                </span>
            </p>
            <p>
                {{ __('State') }}:&nbsp;
                <span>
                    {{ __($data['countryName']) }}
                    @if($data['flag'] !== null)
                        <img src="/storage/media/flags/{{ $data['flag'] }}" alt="{{ __($data['countryName']) }}">
                    @endif
                    {{ $data['countryCode'] }}
                </span>
            </p>
            <p>
                {{ __('City') }}:&nbsp;
                <span>
                    {{ __($data['cityName']) }}&nbsp;
                    @if($data['regionName'] !== null) ({{ __($data['regionName']) }})&nbsp; @endif
                </span>
            </p>
            <p>
                {{ __('Zip code') }}:&nbsp;
                <span>
                    @if($data['zipCode'] !== null)
                        {{ $data['zipCode'] }}
                    @elseif($data['postalCode'] !== null)
                        {{ $data['postalCode'] }}
                    @endif
                </span>
            </p>
            <p>
                {{ __('Timezone') }}:&nbsp;
                <span>{{ $data['timezone'] }}</span>
            </p>
        </div>
    </div>
@endsection