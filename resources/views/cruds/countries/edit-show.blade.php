@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-industry fa-lg fa-fw"></i>
        {{ __(getSingleFullName(\Request::route()->getName())) }}
    </h1>
    <div class="crud-edit-container">
        <h4 class="form-title">{{ __('Information') }}</h4>

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

        @if(str_contains(\Request::route()->getName(), '.show'))

            <div class="form-crud">
                <label class="form-control">
                    <span>{{ __('Name') }}</span>
                    <input type="text" readonly value="{{ $data->name }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Land code') }}</span>
                    <input type="text" readonly value="{{ $data->land_code }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Short code') }}</span>
                    <input type="text" readonly value="{{ $data->short_code }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Geographic zone') }}</span>
                    <input type="text" readonly value="{{ $data->zone }}">
                </label>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            @if($zones->isEmpty())

                <p class="form-warning">{{ __('First create a new Geographic zone before creating a new Country') }}.</p>

            @else

                <form class="form-crud" method="post" action="{{ route('countries.store') }}">
                    @csrf
                    <label class="form-control required">
                        <span>{{ __('Name') }}</span>
                        <input required name="name" type="text" value="{{ old('name') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Land code') }}</span>
                        <input required name="land_code" type="text" value="{{ old('land_code') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Short code') }}</span>
                        <input required name="short_code" type="text" value="{{ old('short_code') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Geographic zone') }}</span>
                        <select name="zone_id" required>
                            <option selected disabled>{{ __('Choose a zone') }}</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="btn yellow" type="submit">{{ __('Save') }}</button>
                </form>

            @endif

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('countries.update', ['country' => $id]) }}">
                @csrf
                @method('PUT')
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Land code') }}</span>
                    <input required type="text" name="land_code" value="{{ $data->land_code }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Short code') }}</span>
                    <input required type="text" name="short_code" value="{{ $data->short_code }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Geographic zone') }}</span>
                    <select name="zone_id" required>
                        <option selected disabled>{{ __('Choose a zone') }}</option>
                        @foreach($zones as $zone)
                            <option @if((int) $zone->id === (int) $data->zone_id) selected @endif value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection