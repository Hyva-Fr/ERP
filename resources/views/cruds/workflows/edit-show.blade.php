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
                    <span>{{ __('Agency') }}</span>
                    <input type="text" readonly value="{{ $data->agency }}">
                </label>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            <form class="form-crud" method="post" action="{{ route('workflows.store') }}">
                @csrf
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required name="name" type="text" value="{{ old('name') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Agency') }}</span>
                    <select name="agency_id" required>
                        <option selected disabled>{{ __('Choose an agency') }}</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('workflows.update', ['workflow' => $id]) }}">
                @csrf
                @method('PUT')

                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Agency') }}</span>
                    <select name="agency_id" required>
                        <option selected disabled>{{ __('Choose an agency') }}</option>
                        @foreach($agencies as $agency)
                            <option @if((int) $agency->id === (int) $data->agency_id) selected @endif value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection