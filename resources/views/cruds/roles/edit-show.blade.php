@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-shield-halved fa-lg fa-fw"></i>
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
                    <span>{{ __('Grants') }}</span>
                    <input type="text" readonly value="{{ implode(', ', $data->constants) }}">
                </label>

            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            <form class="form-crud" method="post" action="{{ route('roles.store') }}">
                @csrf
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required name="name" type="text" value="{{ old('name') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Code') }}</span>
                    <input required name="code" type="text" value="{{ old('code') }}">
                </label>

                <div class="crud-checkbox form-control required">
                    <span>{{ __('Grants') }}</span>
                    @foreach($constantsKeys as $const)
                        <label>
                            <input class="with-font" @if($const === 'BASIC_GROUP') checked @endif value="{{ $const }}" type="checkbox" name="constants[]">
                            <span>{{ $const }}</span>
                        </label>
                    @endforeach
                </div>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('roles.update', ['role' => $id]) }}">
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

                <div class="crud-checkbox form-control required">
                    <span>{{ __('Grants') }}</span>
                    @foreach($constantsKeys as $const)
                        <label>
                            <input class="with-font" value="{{ $const }}" type="checkbox" @if(in_array($const, $data->constants, true)) checked @endif name="constants[]">
                            <span>{{ $const }}</span>
                        </label>
                    @endforeach
                </div>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection