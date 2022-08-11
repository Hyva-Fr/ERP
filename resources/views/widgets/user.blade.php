@extends('layouts.widgets')

@section('all')

    @if($type === 'all')

        <div class="widget-container">
            <div class="widget all-type">
                <ul class="widget-head">
                    <li class="table-33">
                        {{ __('Acitive users') }}
                    </li>
                    <li class="table-33">
                        {{ __('Inactive users') }}
                    </li>
                    <li class="table-33">
                        {{ __('Total') }}
                    </li>
                </ul>
                <ul class="widget-body">
                    <li>
                        <span>{{ $data['active'] }}</span>
                        <span>{{ $data['inactive'] }}</span>
                        <span>{{ $data['total'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

    @endif

@endsection