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
                    <span>{{ __('Code') }}</span>
                    <input type="text" readonly value="{{ $data->code }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Country') }}</span>
                    <input type="text" readonly value="{{ $data->country }}">
                </label>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            @if($countries->isEmpty())

                <p class="form-warning">{{ __('First create a new Country before creating a new State') }}.</p>

            @else

                <form class="form-crud" method="post" action="{{ route('states.store') }}">
                    @csrf
                    <label class="form-control required">
                        <span>{{ __('Name') }}</span>
                        <input required name="name" type="text" value="{{ old('name') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Code') }}</span>
                        <input required name="code" type="text" value="{{ old('code') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Country') }}</span>
                        <select name="country_id" required>
                            <option selected disabled>{{ __('Choose a country') }}</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="btn yellow" type="submit">{{ __('Save') }}</button>
                </form>

            @endif

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('states.update', ['state' => $id]) }}">
                @csrf
                @method('PUT')
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Code') }}</span>
                    <input required type="text" name="code" value="{{ $data->code }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Country') }}</span>
                    <select name="country_id" required>
                        <option selected disabled>{{ __('Choose a country') }}</option>
                        @foreach($countries as $country)
                            <option @if((int) $country->id === (int) $data->country_id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection