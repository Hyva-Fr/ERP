@extends('layouts.errors')

@section('title', __('Banishment'))
@section('code', __('Forbidden access'))
@section('message')
    {!! __('Ip: <b>:ip</b> is banished.', ['ip' => \Request::ip()]) !!}
@endsection
@section('back')
    <p class="partials">
        {!! __('Please contact :mail if you think that\'s a mistake.', ['mail' => '<a class="options-inline" href="mailto:' . env('MAIL_FROM_ADDRESS', '') . '">' . config('app.name') . '</a>']) !!}
    </p>
@endsection