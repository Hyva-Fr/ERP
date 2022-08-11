@extends('layouts.widgets')

@section('all')

    @if($type === 'all')

    <div class="widget-container">
        <div class="widget all-type">
            <ul class="widget-head">
                <li class="table-50">
                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                    {{ __('Agencies') }}
                </li>
                <li class="table-50">
                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                    {{ __('Users') }}
                </li>
            </ul>
            <ul class="widget-body">
                @foreach($data as $agency)
                    <li>
                        <span>{!! $agency['link'] !!}</span>
                        @if(!empty($agency['users']))
                            <ul>
                                @foreach($agency['users'] as $user)
                                    <li>
                                        <span>{!! $user['link'] !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="no-data">{{ __('No data available') }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="widget-container">
        <div class="widget all-type">
            <ul class="widget-head">
                <li class="table-50">
                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                    {{ __('Agencies') }}
                </li>
                <li class="table-50">
                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                    {{ __('Missions') }}
                </li>
            </ul>
            <ul class="widget-body">
                @foreach($data as $agency)
                    <li>
                        <span>{!! $agency['link'] !!}</span>
                        @if(!empty($agency['missions']))
                            <ul>
                                @foreach($agency['missions'] as $mission)
                                    <li>
                                        <span>{!! $mission['link'] !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="no-data">{{ __('No data available') }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @endif

@endsection

@section('single')

    @if($type === 'single')

    <div class="widget-container">
        <div class="widget single-type">
            <ul class="widget-head">
                <li class="full">
                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                    {{ __('Users') }}
                </li>
            </ul>
            <ul class="widget-body">
                @foreach($data['users'] as $user)
                    <li>
                        <span>{!! $user !!}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="widget-container">
        <div class="widget single-type">
            <ul class="widget-head">
                <li class="full">
                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                    {{ __('Missions') }}
                </li>
            </ul>
            <ul class="widget-body">
                @foreach($data['missions'] as $mission)
                    <li>
                        <span>{!! $mission !!}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @endif

@endsection