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
                    <span>{{ __('Category') }}</span>
                    <input type="text" readonly value="{{ $data->category }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Author') }}</span>
                    <input type="text" readonly value="{{ $data->user }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Form') }}</span>
                    <a target="_blank" href="{{ route('pdf.display', ['id' => $data->id]) }}">
                        {{ __('Display') }}
                        <span>
                            {{ $data->category }}-{{ $data->name }}
                            <i class="fa-solid fa-display fa-lg fa-fw"></i>
                        </span>
                    </a>
                    <a target="_blank" href="{{ route('pdf.download', ['id' => $data->id]) }}">
                        {{ __('Print') }}
                        <span>
                            {{ $data->category }}-{{ $data->name }}
                            <i class="fa-solid fa-file-pdf fa-lg fa-fw"></i>
                        </span>
                    </a>
                </label>

            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            <form class="form-crud" method="post" action="{{ route('forms.store') }}">
                @csrf

                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required name="name" type="text" value="{{ old('name') }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Category') }}</span>
                    <select name="category_id" required>
                        <option selected disabled>{{ __('Choose a category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control required">
                    <span>{{ __('Author') }}</span>
                    <select name="user_id" required>
                        <option selected disabled>{{ __('Choose an author') }}</option>
                        @foreach($users as $user)
                            <option @if(Auth::user()->id === $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="form-control required">
                    <span>{{ __('Form creator') }}</span>

                    @php $stdForm = ["header"=>"simple","main"=>["format"=>"section","content"=>[]],"footer"=>"simple"]; @endphp
                    <input type="hidden" name="form" value='@json($stdForm)'/>
                    {!! setForm(json_encode(["header"=>"simple","main"=>["format"=>"section","content"=>[]],"footer"=>"simple"], JSON_THROW_ON_ERROR)) !!}
                </div>

                <button class="btn yellow form-submit" type="submit">{{ __('Save') }}</button>
            </form>

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud form-edit-crud" method="post" action="{{ route('forms.update', ['form' => $id]) }}">
                @csrf
                @method('PUT')

                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Category') }}</span>
                    <select name="category_id" required>
                        <option selected disabled>{{ __('Choose a category') }}</option>
                        @foreach($categories as $category)
                            <option @if((int) $category->id === (int) $data->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control required">
                    <span>{{ __('Author') }}</span>
                    <select name="user_id" required>
                        <option selected disabled>{{ __('Choose an author') }}</option>
                        @foreach($users as $user)
                            <option @if((int) $user->id === (int) $data->user_id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control">
                    <span>{{ __('Form') }}</span>
                    <a target="_blank" href="{{ route('pdf.display', ['id' => $data->id]) }}">
                        {{ __('Display') }}
                        <span>
                            {{ $data->category }}-{{ $data->name }}
                            <i class="fa-solid fa-display fa-lg fa-fw"></i>
                        </span>
                    </a>
                    <a target="_blank" href="{{ route('pdf.download', ['id' => $data->id]) }}">
                        {{ __('Print') }}
                        <span>
                            {{ $data->category }}-{{ $data->name }}
                            <i class="fa-solid fa-file-pdf fa-lg fa-fw"></i>
                        </span>
                    </a>
                </label>

                <div class="form-control required">
                    <span>{{ __('Form creator') }}</span>
                    <input type="hidden" name="form" value='{!! $data->form !!}'/>
                    {!! setForm() !!}
                </div>

                <button class="btn yellow form-submit" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection