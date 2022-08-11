@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-users fa-lg fa-fw"></i>
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

                <div class="full margin">
                    <label for="user-avatar" class="form-control center">
                        <div id="profile-avatar-preview" style="background-image: url('{{ setAvatar($data->avatar) }}');"></div>
                        <span>{{ __('Avatar') }}</span>
                    </label>
                </div>

                <label class="form-control">
                    <span>{{ __('Firstname') }}</span>
                    <input type="text" readonly value="{{ $data->firstname }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Lastname') }}</span>
                    <input type="text" readonly value="{{ $data->lastname }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Email') }}</span>
                    <input type="email" readonly value="{{ $data->email }}">
                </label>

                <label class="form-control employed">
                    <span>{{ __('Employed') }}</span>
                    @if($data->employed)
                        <i class="fa-solid fa-circle-check fa-lg fa-fw green"></i>
                    @else
                        <i class="fa-solid fa-circle-xmark fa-lg fa-fw red"></i>
                    @endif
                </label>

                <label class="form-control">
                    <span>{{ __('Agency') }}</span>
                    <input type="text" readonly value="{{ $data->agency }}">
                </label>

                <div class="crud-checkbox form-control required">
                    <span>{{ __('Roles') }}</span>
                    @foreach($roles as $role)
                        <label>
                            <input disabled class="with-font" value="{{ $role->id }}" type="checkbox" @if(in_array($role->id, $rolesIDs, true)) checked @endif">
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            @if($agencies->isEmpty())

                <p class="form-warning">{{ __('First create a new Agency before creating a new User') }}.</p>

            @else

                <form class="form-crud" method="post" action="{{ route('users.store') }}">
                    @csrf
                    <div class="full margin">
                        <div for="user-avatar" class="form-control center">
                            <div id="profile-avatar-preview" style="background-image: url('{{ setAvatar('') }}');">
                                <span id="pic-trigger">
                                    <i class="fa-solid fa-camera fa-fg fa-fw"></i>
                                </span>
                                <input class="hidden" type="file" id="file-trigger">
                            </div>
                            <input id="user-avatar" type="hidden" name="avatar" value="{{ old('avatar') }}"/>
                            <span>{{ __('Avatar') }}&nbsp;<i id="delete-avatar" class="fa-solid fa-trash crud-actions fa-lg fa-fw" data-url="{{ setAvatar('') }}"></i></span>
                        </div>
                    </div>

                    <label class="form-control required">
                        <span>{{ __('Firstname') }}</span>
                        <input required name="firstname" type="text" value="{{ old('firstname') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Lastname') }}</span>
                        <input required name="lastname" type="text" value="{{ old('lastname') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Email') }}</span>
                        <input required name="email" type="email" value="{{ old('email') }}">
                    </label>

                    <div class="crud-radios form-control">
                        <span>{{ __('Employed') }}</span>
                        <label for="crud-radio-1">
                            <input class="with-font" value="1" id="crud-radio-1" type="radio" checked name="employed">
                            <span>{{ __('Yes') }}</span>
                        </label>
                        <label for="crud-radio-2">
                            <input class="with-font" value="0" id="crud-radio-2" type="radio" name="employed">
                            <span>{{ __('No') }}</span>
                        </label>
                    </div>

                    <label class="form-control required">
                        <span>{{ __('Agency') }}</span>
                        <select name="agency_id" required>
                            <option selected disabled>{{ __('Choose an agency') }}</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="crud-checkbox form-control required">
                        <span>{{ __('Roles') }}</span>
                        @foreach($roles as $role)
                            <label>
                                <input class="with-font" @if($role->code === 'basic') checked @endif value="{{ $role->id }}" type="checkbox" name="roles[]">
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    <button class="btn yellow" type="submit">{{ __('Save') }}</button>
                </form>

            @endif

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('users.update', ['user' => $id]) }}">
                @csrf
                @method('PUT')
                <div class="full margin">
                    <div for="user-avatar" class="form-control center">
                        <div id="profile-avatar-preview" style="background-image: url('{{ setAvatar($data->avatar) }}');">
                        <span id="pic-trigger">
                            <i class="fa-solid fa-camera fa-fg fa-fw"></i>
                        </span>
                            <input class="hidden" type="file" id="file-trigger">
                        </div>
                        <input id="user-avatar" type="hidden" name="avatar" value="{{ $data->avatar }}"/>
                        <span>{{ __('Avatar') }}&nbsp;<i id="delete-avatar" class="fa-solid fa-trash crud-actions fa-lg fa-fw" data-url="{{ setAvatar('') }}"></i></span>
                    </div>
                </div>

                <label class="form-control required">
                    <span>{{ __('Firstname') }}</span>
                    <input required type="text" name="firstname" value="{{ $data->firstname }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Lastname') }}</span>
                    <input required type="text" name="lastname" value="{{ $data->lastname }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Email') }}</span>
                    <input required type="email" name="email" value="{{ $data->email }}">
                </label>

                <div class="crud-radios form-control">
                    <span>{{ __('Employed') }}</span>
                    <label for="crud-radio-1">
                        <input class="with-font" value="1" id="crud-radio-1" type="radio" @if($data->employed) checked @endif name="employed">
                        <span>{{ __('Yes') }}</span>
                    </label>
                    <label for="crud-radio-2">
                        <input class="with-font" value="0" id="crud-radio-2" type="radio" @if(!$data->employed) checked @endif name="employed">
                        <span>{{ __('No') }}</span>
                    </label>
                </div>

                <label class="form-control required">
                    <span>{{ __('Agency') }}</span>
                    <select name="agency_id" required>
                        <option selected disabled>{{ __('Choose an agency') }}</option>
                        @foreach($agencies as $agency)
                            <option @if((int) $agency->id === (int) $data->agency_id) selected @endif value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="crud-checkbox form-control required">
                    <span>{{ __('Roles') }}</span>
                    @foreach($roles as $role)
                        <label>
                            <input class="with-font" value="{{ $role->id }}" type="checkbox" @if(in_array($role->id, $rolesIDs, true)) checked @endif name="roles[]">
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection