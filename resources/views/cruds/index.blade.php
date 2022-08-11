@extends('layouts.template')

@section('content')

    <h1>
        {!! getIcon(commonRoute()) !!}
        {{ ucfirst(__(str_replace(['-', '_'], ' ', commonRoute()) . ' list')) }}
    </h1>
    <div class="crud-index-container">
        @if(!in_array(commonRoute(), ['forms', 'completed-forms']))
            <a class="yellow crud-add-btn btn desktop" href="{{ route(commonRoute() . '.create') }}">{{ __('Add new record') }}</a>
            <a class="yellow crud-add-btn btn mobile" href="{{ route(commonRoute() . '.create') }}">
                <i class="fa-solid fa-circle-plus"></i>
            </a>
        @endif
        <div class="crud-info">
            <p>{!! __('Here you can have a look at the <b>:attribute</b> records, and also create, update or delete any single record.', ['attribute' => ucfirst(__(str_replace(['-', '_'], ' ', commonRoute())))]) !!}</p>
            {{--<p>{!! __('Need some help about the whole workflow involving the <b>:attribute</b> records ?<br>Please check the <a href="/workflow">:workflow</a> section.', ['attribute' => ucfirst(__(str_replace(['-', '_'], ' ', commonRoute()))), 'workflow' => ucfirst(__('workflow'))]) !!}</p>--}}
        </div>
        @include('cruds.filters')
        @include('cruds.table')
    </div>

    @if(commonRoute() === 'categories')
        {!! getCategories() !!}
    @endisset
    @isset($widget) {!! $widget !!} @endisset

@endsection