@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/dimmers.css') }}">
@endprepend

<section id="dimmers-section">
    @foreach($dimmers as $key => $dimmer)
        <!-- Dimmer n°{{ $key + 1 }} -->
        <div style="width: {{ $dimmer['size'] }}" class="dimmers-containers" id="dimmer-{{ $key + 1 }}">
            {!! $dimmer['class'] !!}
        </div>
    @endforeach
</section>

@prepend('scripts')
    <script type="text/javascript" src="{{ mix('js/dimmers.js') }}"></script>
@endprepend