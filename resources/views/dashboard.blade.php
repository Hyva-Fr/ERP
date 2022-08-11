@extends('layouts.template')

@section('content')

    <h1>
        <i class="fa-solid fa-house fa-lg fa-fw"></i>
        {{ __('Dashboard') }}
    </h1>
    {!! $dimmers !!}
@endsection
