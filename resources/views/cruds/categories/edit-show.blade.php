@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-list-check fa-lg fa-fw"></i>
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
                    <span>{{ __('Parent category') }}</span>
                    @if(is_null($data->parent))
                        <input type="text" readonly value="{{ __('None') }}">
                    @else
                        @foreach($parents as $parent)
                            @if((int) $parent->id === (int) $data->parent)
                                <input type="text" readonly value="{{ $parent->name }}">
                            @endif
                        @endforeach
                    @endif
                </label>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            <form class="form-crud" method="post" action="{{ route('categories.store') }}">
                @csrf

                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required name="name" type="text" value="{{ old('name') }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Parent category') }}</span>
                    <select name="parent">
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('categories.update', ['category' => $id]) }}">
                @csrf
                @method('PUT')

                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Parent category') }}</span>
                    <select name="parent">
                        @foreach($parents as $parent)
                            <option @if((int) $parent->id === (int) $data->parent) selected @endif value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>
    @isset($id)
        {!! getCategories($id) !!}
    @else
        {!! getCategories() !!}
    @endisset
    @isset($widget) {!! $widget !!} @endisset

@endsection