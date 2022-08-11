@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-tags fa-lg fa-fw"></i>
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
                    <span>{{ __('Description') }}</span>
                    <textarea readonly>{{ $data->description }}</textarea>
                </label>

                <label class="form-control">
                    <span>{{ __('Street') }}</span>
                    <input type="text" readonly value="{{ $data->street }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Zip code') }}</span>
                    <input type="text" readonly value="{{ $data->zip }}">
                </label>

                <label class="form-control">
                    <span>{{ __('City') }}</span>
                    <input type="text" readonly value="{{ $data->city }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Country') }}</span>
                    <input type="text" readonly value="{{ $data->country }}">
                </label>

            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            <form class="form-crud" method="post" action="{{ route('societies.store') }}">
                @csrf
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required name="name" type="text" value="{{ old('name') }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Description') }}</span>
                    <textarea required name="description">{{ old('description') }}</textarea>
                </label>

                <label class="form-control required">
                    <span>{{ __('Street') }}</span>
                    <input required name="street" type="text" value="{{ old('street') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Zip code') }}</span>
                    <input required name="zip" type="text" value="{{ old('zip') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('City') }}</span>
                    <input required name="city" type="text" value="{{ old('city') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Country') }}</span>
                    <input required name="country" type="text" value="{{ old('country') }}">
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('societies.update', ['society' => $id]) }}">
                @csrf
                @method('PUT')
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Description') }}</span>
                    <textarea name="description">{{ $data->description }}</textarea>
                </label>

                <label class="form-control required">
                    <span>{{ __('Street') }}</span>
                    <input required type="text" name="street" value="{{ $data->street }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Zip code') }}</span>
                    <input required type="text" name="zip" value="{{ $data->zip }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('City') }}</span>
                    <input required type="text" name="city" value="{{ $data->city }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Country') }}</span>
                    <input required type="text" name="country" value="{{ $data->country }}">
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection