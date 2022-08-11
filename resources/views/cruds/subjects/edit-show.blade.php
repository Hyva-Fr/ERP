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
                    <span>{{ __('Order') }}</span>
                    <input type="number" readonly value="{{ $data->order }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Workflow') }}</span>
                    <input type="text" readonly value="{{ $data->workflow }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Process') }}</span>
                    <input type="text" readonly value="{{ $data->process }}">
                </label>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            @if($workflows->isEmpty())

                <p class="form-warning">{{ __('First create a new Workflow before creating a new Subject') }}.</p>

            @elseif($processes->isEmpty())

                <p class="form-warning">{{ __('First create a new Process before creating a new Subject') }}.</p>

            @else

                <form class="form-crud" method="post" action="{{ route('subjects.store') }}">
                    @csrf
                    <label class="form-control required">
                        <span>{{ __('Name') }}</span>
                        <input required name="name" type="text" value="{{ old('name') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Order') }}</span>
                        <input required name="order" min="1" type="number" value="{{ old('order') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Workflow') }}</span>
                        <select name="workflow_id" required>
                            <option selected disabled>{{ __('Choose a workflow') }}</option>
                            @foreach($workflows as $workflow)
                                <option value="{{ $workflow->id }}">{{ $workflow->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Process') }}</span>
                        <select name="process_id" required>
                            <option selected disabled>{{ __('Choose a process') }}</option>
                            @foreach($processes as $process)
                                <option value="{{ $process->id }}">{{ $process->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="btn yellow" type="submit">{{ __('Save') }}</button>
                </form>

            @endif

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" action="{{ route('subjects.update', ['subject' => $id]) }}">
                @csrf
                @method('PUT')

                <label class="form-control required">
                    <span>{{ __('Name') }}</span>
                    <input required type="text" name="name" value="{{ $data->name }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Order') }}</span>
                    <input required type="number" min="1" name="order" value="{{ $data->order }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Workflow') }}</span>
                    <select name="workflow_id" required>
                        <option selected disabled>{{ __('Choose a workflow') }}</option>
                        @foreach($workflows as $workflow)
                            <option @if((int) $workflow->id === (int) $data->workflow_id) selected @endif value="{{ $workflow->id }}">{{ $workflow->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control required">
                    <span>{{ __('Process') }}</span>
                    <select name="process_id" required>
                        <option selected disabled>{{ __('Choose a process') }}</option>
                        @foreach($processes as $process)
                            <option @if((int) $process->id === (int) $data->process_id) selected @endif value="{{ $process->id }}">{{ $process->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection