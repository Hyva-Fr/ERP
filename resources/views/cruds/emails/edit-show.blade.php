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
                    <span>{{ __('Subject') }}</span>
                    <input type="text" readonly value="{{ $data->subject }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Template') }}</span>
                    <input type="text" readonly value="{{ ucfirst(str_replace('.blade.php', '', $data->template)) }}">
                </label>

                <div class="form-control">
                    <span>{{ __('Content') }}</span>
                    <div class="email-container">
                        {{ $data->content }}
                    </div>
                </div>

            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            <form class="form-crud" method="post" action="{{ route('emails.store') }}">
                @csrf
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required name="name" type="text" value="{{ old('name') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Subject') }}</span>
                    <input required name="subject" type="text" value="{{ old('subject') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Template') }}</span>
                    <select name="template" required>
                        <option selected disabled>{{ __('Choose a template') }}</option>
                        @foreach($templates as $template)
                            <option value="{{ $template }}">{{ ucfirst(str_replace('.blade.php', '', $template)) }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control wrap required">
                    <span>{{ __('Content') }}</span>
                    <textarea id="email-content" class="tiny" required name="content">{{ old('content') }}</textarea>
                    {!! shortCodesList($shortCodes) !!}
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('emails.update', ['email' => $id]) }}">
                @csrf
                @method('PUT')
                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Subject') }}</span>
                    <input required type="text" name="subject" value="{{ $data->subject }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Template') }}</span>
                    <select name="template" required>
                        <option selected disabled>{{ __('Choose a template') }}</option>
                        @foreach($templates as $template)
                            <option @if($template === $data->template) selected @endif value="{{ $template }}">{{ ucfirst(str_replace('.blade.php', '', $template)) }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control wrap required">
                    <span>{{ __('Content') }}</span>
                    <textarea id="email-content" class="tiny" required name="content">{{ $data->content }}</textarea>
                    {!! shortCodesList($shortCodes) !!}
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection