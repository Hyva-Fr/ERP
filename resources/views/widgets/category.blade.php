@extends('layouts.widgets')

@section('all')

    @if($type === 'all')

    <div class="widget-container">
            <div class="widget all-type">
                <ul class="widget-head">
                    <li class="table-50">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('Categories') }}
                    </li>
                    <li class="table-50">
                        <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                        {{ __('Forms') }}
                    </li>
                </ul>
                <ul class="widget-body">
                    @foreach($data as $category)
                        <li>
                            <span>{!! $category['link'] !!}</span>
                            @if(!empty($category['forms']))
                                <ul>
                                    @foreach($category['forms'] as $form)
                                        <li>
                                            <span>{!! $form['link'] !!}</span>
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
                        {{ __('Forms') }}
                    </li>
                </ul>
                <ul class="widget-body">
                    @foreach($data as $form)
                        <li>
                            <span>{!! $form['link'] !!}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif

@endsection