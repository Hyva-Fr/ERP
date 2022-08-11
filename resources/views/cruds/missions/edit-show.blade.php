@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-barcode fa-lg fa-fw"></i>
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
                    <span>{{ __('Serial') }}</span>
                    <input type="text" readonly value="{{ $data->serial }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Review') }}</span>
                    <input type="text" readonly value="{{ $data->review }}">
                </label>

                <div class="pics-container">

                    <label class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Distribution plan') }}</span>
                        @if($data->distribution_plan !== null)
                            <a class="file-link" target="_blank" href="{{ config('app.url') }}/storage/{{ $data->distribution_plan }}">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span>{{ str_replace('missions/' . $data->id . '/', '', $data->distribution_plan) }}</span>
                            </a>
                        @else
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                {{ __('No file available') }}
                            </i>
                        @endif
                    </label>

                    <label class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Clamping plan') }}</span>
                        @if($data->clamping_plan !== null)
                            <a class="file-link" target="_blank" href="{{ config('app.url') }}/storage/{{ $data->clamping_plan }}">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span>{{ str_replace('missions/' . $data->id . '/', '', $data->clamping_plan) }}</span>
                            </a>
                        @else
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                {{ __('No file available') }}
                            </i>
                        @endif
                    </label>

                    <label class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Electrical diagram') }}</span>
                        @if($data->electrical_diagram !== null)
                            <a class="file-link" target="_blank" href="{{ config('app.url') }}/storage/{{ $data->electrical_diagram }}">
                                <i class="fa-solid fa-file-excel green fa-lg fa-fw"></i>
                                <span>{{ str_replace('missions/' . $data->id . '/', '', $data->electrical_diagram) }}</span>
                            </a>
                        @else
                            <i class="no-file">
                                <i class="fa-solid fa-file-excel green fa-lg fa-fw"></i>
                                {{ __('No file available') }}
                            </i>
                        @endif
                    </label>

                    <label class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Workshops help') }}</span>
                        @if($data->workshops_help !== null)
                            <a class="file-link" target="_blank" href="{{ config('app.url') }}/storage/{{ $data->workshops_help }}">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span>{{ str_replace('missions/' . $data->id . '/', '', $data->workshops_help) }}</span>
                            </a>
                        @else
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                {{ __('No file available') }}
                            </i>
                        @endif
                    </label>

                    <label class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Receipt') }}</span>
                        @if($data->receipt !== null)
                            <a class="file-link" target="_blank" href="{{ config('app.url') }}/storage/{{ $data->receipt }}">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span>{{ str_replace('missions/' . $data->id . '/', '', $data->receipt) }}</span>
                            </a>
                        @else
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                {{ __('No file available') }}
                            </i>
                        @endif
                    </label>

                    <label class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Delivery note') }}</span>
                        @if($data->delivery_note !== null)
                            <a class="file-link" target="_blank" href="{{ config('app.url') }}/storage/{{ $data->delivery_note }}">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span>{{ str_replace('missions/' . $data->id . '/', '', $data->delivery_note) }}</span>
                            </a>
                        @else
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                {{ __('No file available') }}
                            </i>
                        @endif
                    </label>

                </div>

                <label class="form-control">
                    <span>{{ __('Society') }}</span>
                    <input type="text" readonly value="{{ $data->society }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Agency') }}</span>
                    <input type="text" readonly value="{{ $data->agency }}">
                </label>

                <label class="form-control">
                    <span>{{ __('Description') }}</span>
                    <textarea readonly>{{ $data->description }}</textarea>
                </label>

                <label class="form-control employed">
                    <span>{{ __('Done') }}</span>
                    @if($data->done)
                        <i class="fa-solid fa-circle-check fa-lg fa-fw green"></i>
                    @else
                        <i class="fa-solid fa-circle-xmark fa-lg fa-fw red"></i>
                    @endif
                </label>

                <label class="form-control">
                    <span>{{ __('Comments') }}</span>
                    <div class="comments-container">
                        @if($comments->isEmpty())
                            <i>{{ __('No comment available') }}</i>
                        @else
                            @foreach($comments as $comment)
                                <div class="comment">
                                    <span>{{ $comment->name }} <small>{{ $comment->created_at->isoFormat('llll') }}</small></span>
                                    <pre>{{ $comment->comment }}</pre>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </label>


                <label class="form-control">
                    <span>{{ __('Images') }}</span>
                    @if(empty($data->images))
                        <i class="no-file">{{ __('No file available') }}</i>
                    @else
                        <div class="images-container">
                            @php $cnt = 1; @endphp
                            @foreach($data->images as $image)
                                <div class="image-container xLarge-3 large-3 medium-6 small-12 xSmall-12">
                                    <a target="_blank" href="{{ config('app.url') }}/storage/{{ $image }}">
                                        <img src="{{ config('app.url') }}/storage/{{ $image }}" class="images" alt="{{ $data->serial }}-{{ $cnt }}">
                                    </a>
                                    <span>{{ str_replace('missions/' . $data->id . '/images/', '', $image) }}</span>
                                </div>
                                @php $cnt++; @endphp
                            @endforeach
                        </div>
                    @endif
                </label>
            </div>

        @elseif(str_contains(\Request::route()->getName(), '.create'))

            @if($societies->isEmpty())

                <p class="form-warning">{{ __('First create a new Society before creating a new Mission') }}.</p>

            @elseif($agencies->isEmpty())

                <p class="form-warning">{{ __('First create a new Agency before creating a new Mission') }}.</p>

            @else

                <form class="form-crud" method="post" enctype="multipart/form-data" action="{{ route('missions.store') }}">
                    @csrf
                    <label class="form-control required">
                        <span>{{ __('Serial') }}</span>
                        <input required name="serial" type="text" value="{{ old('serial') }}">
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Review') }}</span>
                        <input required name="review" type="text" value="{{ old('review') }}">
                    </label>

                    <div class="pics-container" data-replace="{{ __('Bad format') }}">

                        <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                            <span>{{ __('Distribution plan') }}</span>
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span class="file-title">{{ __('Upload a file') }}</span>
                            </i>
                            <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                            <input class="hidden file-trigger" accept="application/pdf" type="file" name="distribution_plan">
                        </div>

                        <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                            <span>{{ __('Clamping plan') }}</span>
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span class="file-title">{{ __('Upload a file') }}</span>
                            </i>
                            <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                            <input class="hidden file-trigger" accept="application/pdf" type="file" name="clamping_plan">
                        </div>

                        <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                            <span>{{ __('Electrical diagram') }}</span>
                            <i class="no-file">
                                <i class="fa-solid fa-file-excel green fa-lg fa-fw"></i>
                                <span class="file-title">{{ __('Upload a file') }}</span>
                            </i>
                            <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                            <input class="hidden file-trigger" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" name="electrical_diagram">
                        </div>

                        <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                            <span>{{ __('Workshops help') }}</span>
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span class="file-title">{{ __('Upload a file') }}</span>
                            </i>
                            <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                            <input class="hidden file-trigger" accept="application/pdf" type="file" name="workshops_help">
                        </div>

                        <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                            <span>{{ __('Receipt') }}</span>
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span class="file-title">{{ __('Upload a file') }}</span>
                            </i>
                            <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                            <input class="hidden file-trigger" accept="application/pdf" type="file" name="receipt">
                        </div>

                        <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                            <span>{{ __('Delivery note') }}</span>
                            <i class="no-file">
                                <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                                <span class="file-title">{{ __('Upload a file') }}</span>
                            </i>
                            <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                            <input class="hidden file-trigger" accept="application/pdf" type="file" name="delivery_note">
                        </div>

                    </div>

                    <label class="form-control required">
                        <span>{{ __('Societies') }}</span>
                        <select name="society_id" required>
                            <option selected disabled>{{ __('Choose a society') }}</option>
                            @foreach($societies as $society)
                                <option value="{{ $society->id }}">{{ $society->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control required">
                        <span>{{ __('Agencies') }}</span>
                        <select name="agency_id" required>
                            <option selected disabled>{{ __('Choose an agency') }}</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control">
                        <span>{{ __('Description') }}</span>
                        <textarea name="description">{{ old('description') }}</textarea>
                    </label>

                    <div class="crud-radios form-control">
                        <span>{{ __('Done') }}</span>
                        <label for="crud-radio-1">
                            <input class="with-font" value="1" id="crud-radio-1" type="radio" name="done">
                            <span>{{ __('Yes') }}</span>
                        </label>
                        <label for="crud-radio-2">
                            <input class="with-font" value="0" id="crud-radio-2" type="radio" checked name="done">
                            <span>{{ __('No') }}</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <span>{{ __('Images') }}</span>
                        <div id="new-images-container">
                            <button class="btn yellow" type="button">
                                <span class="desktop">{{ __('Add images') }}</span>
                                <i class="fa-solid fa-circle-plus mobile"></i>
                            </button>
                            <ul id="new-files-lister"></ul>
                            <input id="files-trigger" class="hidden" type="file" multiple accept="image/*" name="images[]">
                        </div>
                    </div>

                    <button class="btn yellow" type="submit">{{ __('Save') }}</button>
                </form>

            @endif

        @elseif(str_contains(\Request::route()->getName(), '.edit'))

            <form class="form-crud" method="post" enctype="multipart/form-data" action="{{ route('missions.update', ['mission' => $id]) }}">
                @csrf
                @method('PUT')
                <label class="form-control required">
                    <span>{{ __('Serial') }}</span>
                    <input required name="serial" type="text" value="{{ $data->serial }}">
                </label>

                <label class="form-control required">
                    <span>{{ __('Review') }}</span>
                    <input required name="review" type="text" value="{{ $data->review }}">
                </label>

                <div class="pics-container" data-replace="{{ __('Bad format') }}">

                    <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Distribution plan') }}</span>
                        <i class="no-file">
                            <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                            <span class="file-title">
                                @if(is_null($data->distribution_plan))
                                {{ __('Upload a file') }}
                                @else
                                {{ str_replace('missions/' . $data->id . '/', '', $data->distribution_plan) }}
                                @endif
                            </span>
                        </i>
                        <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                        <input class="hidden file-trigger" accept="application/pdf" type="file" name="distribution_plan">
                    </div>

                    <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Clamping plan') }}</span>
                        <i class="no-file">
                            <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                            <span class="file-title">
                                @if(is_null($data->clamping_plan))
                                    {{ __('Upload a file') }}
                                @else
                                    {{ str_replace('missions/' . $data->id . '/', '', $data->clamping_plan) }}
                                @endif
                            </span>
                        </i>
                        <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                        <input class="hidden file-trigger" accept="application/pdf" type="file" name="clamping_plan">
                    </div>

                    <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Electrical diagram') }}</span>
                        <i class="no-file">
                            <i class="fa-solid fa-file-excel green fa-lg fa-fw"></i>
                            <span class="file-title">
                                @if(is_null($data->electrical_diagram))
                                    {{ __('Upload a file') }}
                                @else
                                    {{ str_replace('missions/' . $data->id . '/', '', $data->electrical_diagram) }}
                                @endif
                            </span>
                        </i>
                        <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                        <input class="hidden file-trigger" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" name="electrical_diagram">
                    </div>

                    <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Workshops help') }}</span>
                        <i class="no-file">
                            <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                            <span class="file-title">
                                @if(is_null($data->workshops_help))
                                    {{ __('Upload a file') }}
                                @else
                                    {{ str_replace('missions/' . $data->id . '/', '', $data->workshops_help) }}
                                @endif
                            </span>
                        </i>
                        <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                        <input class="hidden file-trigger" accept="application/pdf" type="file" name="workshops_help">
                    </div>

                    <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Receipt') }}</span>
                        <i class="no-file">
                            <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                            <span class="file-title">
                                @if(is_null($data->receipt))
                                    {{ __('Upload a file') }}
                                @else
                                    {{ str_replace('missions/' . $data->id . '/', '', $data->receipt) }}
                                @endif
                            </span>
                        </i>
                        <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                        <input class="hidden file-trigger" accept="application/pdf" type="file" name="receipt">
                    </div>

                    <div class="form-control file-form xLarge-3 large-3 medium-6 small-12 xSmall-12">
                        <span>{{ __('Delivery note') }}</span>
                        <i class="no-file">
                            <i class="fa-solid fa-file-pdf red fa-lg fa-fw"></i>
                            <span class="file-title">
                                @if(is_null($data->delivery_note))
                                    {{ __('Upload a file') }}
                                @else
                                    {{ str_replace('missions/' . $data->id . '/', '', $data->delivery_note) }}
                                @endif
                            </span>
                        </i>
                        <button type="button" class="btn white">{{ __('Choose a file') }}</button>
                        <input class="hidden file-trigger" accept="application/pdf" type="file" name="delivery_note">
                    </div>

                </div>

                <label class="form-control required">
                    <span>{{ __('Societies') }}</span>
                    <select name="society_id" required>
                        <option selected disabled>{{ __('Choose a society') }}</option>
                        @foreach($societies as $society)
                            <option @if((int) $society->id === (int) $data->society_id) selected @endif value="{{ $society->id }}">{{ $society->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control required">
                    <span>{{ __('Agencies') }}</span>
                    <select name="agency_id" required>
                        <option selected disabled>{{ __('Choose an agency') }}</option>
                        @foreach($agencies as $agency)
                            <option @if((int) $agency->id === (int) $data->agency_id) selected @endif value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control">
                    <span>{{ __('Description') }}</span>
                    <textarea name="description">{{ $data->description }}</textarea>
                </label>

                <div class="crud-radios form-control">
                    <span>{{ __('Done') }}</span>
                    <label for="crud-radio-1">
                        <input class="with-font" value="1" id="crud-radio-1" type="radio" @if($data->done) checked @endif name="done">
                        <span>{{ __('Yes') }}</span>
                    </label>
                    <label for="crud-radio-2">
                        <input class="with-font" value="0" id="crud-radio-2" type="radio" @if(!$data->done) checked @endif name="done">
                        <span>{{ __('No') }}</span>
                    </label>
                </div>

                <label class="form-control">
                    <span>{{ __('Comments') }}</span>
                    <div class="comments-container">
                        @if($comments->isEmpty())
                            <i>{{ __('No comment available') }}</i>
                        @else
                            @foreach($comments as $comment)
                                <div class="comment">
                                    <span>{{ $comment->name }} <small>{{ $comment->created_at->isoFormat('llll') }}</small></span>
                                    <pre>{{ $comment->comment }}</pre>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <span class="new-comment">{{ __('New comment') }}</span>
                    <textarea name="comments"></textarea>
                </label>

                <div class="form-control">
                    <span>{{ __('Images') }}</span>
                    <div id="new-images-container">
                        <button class="btn yellow" type="button">
                            <span class="desktop">{{ __('Add images') }}</span>
                            <i class="fa-solid fa-circle-plus mobile"></i>
                        </button>
                        <ul id="new-files-lister"></ul>
                        <input id="files-trigger" class="hidden" type="file" multiple accept="image/*" name="images[]">
                    </div>
                    @if(empty($data->images))
                        <i class="no-file">{{ __('No file available') }}</i>
                    @else
                        <div class="images-container">
                            @php $cnt = 1; @endphp
                            @foreach($data->images as $image)
                                <div class="image-container xLarge-3 large-3 medium-6 small-12 xSmall-12">
                                    <a target="_blank" href="{{ config('app.url') }}/storage/{{ $image }}">
                                        <img src="{{ config('app.url') }}/storage/{{ $image }}" class="images" alt="{{ $data->serial }}-{{ $cnt }}">
                                    </a>
                                    <span>{{ str_replace('missions/' . $data->id . '/images/', '', $image) }}&nbsp;<i class="fa-solid fa-trash crud-actions delete-image-mission fa-lg fa-fw" title="{{ __('Delete image') }} {{ str_replace('missions/' . $data->id . '/images/', '', $image) }}" data-path="{{ $image }}" data-id="{{ $data->id }}"></i></span>
                                </div>
                                @php $cnt++; @endphp
                            @endforeach
                        </div>
                    @endif
                </div>
                <button class="btn yellow" type="submit">{{ __('Save') }}</button>
            </form>

        @endif

    </div>

    @isset($widget) {!! $widget !!} @endisset

@endsection