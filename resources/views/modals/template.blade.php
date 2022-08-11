<div class="modal-container" {{ (!isset($slug)) ? 'id=modal-quantic' : '' }}>
    <div class="modal {{ $slug ?? '' }}">
        <div class="modal-title">
            <h4>@yield('modal-title')</h4>
            <i class="fa-solid fa-xmark fa-lg fa-fw"></i>
        </div>
        <div class="modal-content">
            @yield('modal-content')
        </div>
    </div>
</div>