<header>
    <a href="{{ route('dashboard') }}">{!! svg('hyva', 'header-logo-icon') !!}</a>
    <div>
        <a href="{{ route('profile') }}">
            <i class="fa-solid fa-user fa-lg fa-fw"></i>
        </a>
        <div id="notifications">
            <i class="fa-solid fa-bell fa-lg fa-fw"></i>
            <div id="notif-container">
                <ul>
                    <li>Notif 1</li>
                    <li>Notif 2</li>
                    <li>Notif 3</li>
                    <li>Notif 4</li>
                </ul>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nude pointer" type="submit">
                <i class="fa-solid fa-right-from-bracket fa-lg fa-fw"></i>
            </button>
        </form>
        <i id="burger-icon" class="fa-solid fa-bars pointer fa-lg fa-fw"></i>
    </div>
</header>