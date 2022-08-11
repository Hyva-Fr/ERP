@extends('layouts.widgets')

@section('all')

    @if($type === 'all')

        <div class="widget-container">
            <div class="widget all-type">
                <ul class="widget-head">
                    <li class="table-33">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('Countries') }}
                    </li>
                    <li class="table-33">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('States') }}
                    </li>
                    <li class="table-33">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('Agencies') }}
                    </li>
                </ul>
                <ul class="widget-body">
                    @foreach($data as $country)
                        <li>
                            <span>{!! $country['link'] !!}</span>
                            @if(!empty($country['states']))
                                <ul>
                                    @foreach($country['states'] as $state)
                                        <li>
                                            <span>{!! $state['link'] !!}</span>
                                            @if(!empty($state['agencies']))
                                                <ul>
                                                    @foreach($state['agencies'] as $agency)
                                                        <li>
                                                            <span>{!! $agency['link'] !!}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="no-data">{{ __('No data available') }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="no-data">{{ __('No data available') }}</span>
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
                    <li class="table-50">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('States') }}
                    </li>
                    <li class="table-50">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('Agencies') }}
                    </li>
                </ul>
                <ul class="widget-body">
                    @foreach($data as $state)
                        <li>
                            <span>{!! $state['link'] !!}</span>
                            @if(!empty($state['agencies']))
                                <ul>
                                    @foreach($state['agencies'] as $agency)
                                        <li>
                                            <span>{!! $agency['link'] !!}</span>
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