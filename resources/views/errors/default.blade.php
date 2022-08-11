@extends('layouts.errors')

@section('title', __($message))
@section('code', __(':error Error', ['error' => $code]))
@section('message', __($message))
@section('back')
    <a class="options" href="/">{{ __('Back to home') }}</a>
@endsection
