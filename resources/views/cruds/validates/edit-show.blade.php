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
                    <span>{{ __('Form') }}</span>
                    <input type="text" readonly value="{{ formatForm($form) }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Mission') }}</span>
                    <input type="text" readonly value="{{ formatMission($mission) }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Agency') }}</span>
                    <input type="text" readonly value="{{ $agency->name }}">
                </label>

                <label class="form-control">
                    <span>{{ __('User') }}</span>
                    <input type="text" readonly value="{{ $user->name }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Form') }}</span>
                    <a target="_blank" href="{{ route('pdf.display', ['type' => 'validate', 'id' => $data->id]) }}">
                        {{ __('Display') }}
                        <span>
                            {{ $data->mission }}-{{ $data->name }}
                            <i class="fa-solid fa-file-pdf fa-lg fa-fw"></i>
                        </span>
                    </a>
                    <a target="_blank" href="{{ route('pdf.download', ['type' => 'validate', 'id' => $data->id]) }}">
                        {{ __('Download') }}
                        <span>
                            {{ $data->mission }}-{{ $data->name }}
                            <i class="fa-solid fa-cloud-arrow-down fa-lg fa-fw"></i>
                        </span>
                    </a>
                </label>

            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            @if($missions->isEmpty())

                <p class="form-warning">{{ __('First create a new Mission before creating a new Completed form') }}.</p>

            @elseif($forms->isEmpty())

                <p class="form-warning">{{ __('First create a new Form before creating a new Completed form') }}.</p>

            @elseif($users->isEmpty())

                <p class="form-warning">{{ __('First create a new User before creating a new Completed form') }}.</p>

            @else

                <form class="form-crud" method="post" action="{{ route('completed-forms.store') }}">
                    @csrf

                    <label class="form-control required">
                        <span>{{ __('Form') }}</span>
                        <select name="form_id" required>
                            <option selected disabled>{{ __('Choose a form') }}</option>
                            @foreach($forms as $form)
                                <option value="{{ $form->id }}">{{ $form->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Mission') }}</span>
                        <select name="mission_id" required>
                            <option selected disabled>{{ __('Choose a mission') }}</option>
                            @foreach($missions as $mission)
                                <option value="{{ $mission->id }}">{{ $mission->name }}</option>
                            @endforeach
                        </select>
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

                    <label class="form-control required">
                        <span>{{ __('User') }}</span>
                        <select name="user_id" required>
                            <option selected disabled>{{ __('Choose a user') }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control">
                        <span>{{ __('Form') }}</span>
                        <i>{{ __('Links will be generated after save action.') }}</i>
                    </label>

                    <button class="btn yellow" type="submit">{{ __('Save') }}</button>
                </form>

                <div class="form-crud">
                    <label class="form-control">
                        <span>{{ __('Form editor') }}</span>
                        {!! getForm('') !!}
                    </label>
                </div>

            @endif

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('completed-forms.update', ['completed_form' => $id]) }}">
                @csrf
                @method('PUT')

                <label class="form-control required">
                    <span>{{ __('Form') }}</span>
                    <select name="form_id" required>
                        <option selected disabled>{{ __('Choose a form') }}</option>
                        @foreach($forms as $form)
                            <option @if((int) $form->id === (int) $data->form_id) selected @endif value="{{ $form->id }}">{{ $form->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control required">
                    <span>{{ __('Mission') }}</span>
                    <select name="mission_id" required>
                        <option selected disabled>{{ __('Choose a mission') }}</option>
                        @foreach($missions as $mission)
                            <option @if((int) $mission->id === (int) $data->mission_id) selected @endif value="{{ $mission->id }}">{{ $mission->name }}</option>
                        @endforeach
                    </select>
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

                <label class="form-control required">
                    <span>{{ __('User') }}</span>
                    <select name="user_id" required>
                        <option selected disabled>{{ __('Choose a user') }}</option>
                        @foreach($users as $user)
                            <option @if((int) $user->id === (int) $data->user_id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control">
                    <span>{{ __('Form') }}</span>
                    <a target="_blank" href="{{ route('pdf.display', ['type' => 'validate', 'id' => $data->id]) }}">
                        {{ __('Display') }}
                        <span>
                            {{ $data->mission }}-{{ $data->name }}
                            <i class="fa-solid fa-file-pdf fa-lg fa-fw"></i>
                        </span>
                    </a>
                    <a target="_blank" href="{{ route('pdf.download', ['type' => 'validate', 'id' => $data->id]) }}">
                        {{ __('Download') }}
                        <span>
                            {{ $data->mission }}-{{ $data->name }}
                            <i class="fa-solid fa-cloud-arrow-down fa-lg fa-fw"></i>
                        </span>
                    </a>
                </label>

                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

            <div class="form-crud">
                <label class="form-control">
                    <span>{{ __('Form creator') }}</span>
                    {!! getForm($data->content) !!}
                </label>
            </div>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection