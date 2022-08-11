@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/widgets.css') }}">
@endprepend

<div class="relations-widget">
    <h4 class="form-title">{{ __('Relations') }}</h4>
@if($type === 'all')

    @yield('all')

@elseif($type === 'single')

    @yield('single')

@endif
</div>

@prepend('scripts')
    <script type="text/javascript" src="{{ mix('js/widgets.js') }}"></script>
@endprepend