<form method="POST" action="{{ route('user-profile-information.update') }}" class="section full profile-container">
    @csrf
    @method('PUT')
    <h3 class="step-title">{{ __('Profile information') }}</h3>
    <div class="errors-container">
    @if ($errors->any())
        <p class="partials error">{{ __('Whoops! Something went wrong.') }}</p>
        <ul class="partials errors-list">
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    </div>

    <div class="full margin">
        <label for="user-avatar" class="form-control center">
            <div id="profile-avatar-preview" style="background-image: url('{{ setAvatar(auth()->user()->avatar) }}');">
                <span id="pic-trigger">
                    <i class="fa-solid fa-camera fa-fg fa-fw"></i>
                </span>
                <input class="hidden" type="file" id="file-trigger">
            </div>
            <input id="user-avatar" type="hidden" name="avatar" value="{{ old('avatar') ?? auth()->user()->avatar }}"/>
            <span>{{ __('Avatar') }}&nbsp;<i id="delete-avatar" class="fa-solid fa-trash crud-actions fa-lg fa-fw" data-url="{{ setAvatar('') }}"></i></span>
        </label>
    </div>

    <div class="xLarge-4 large-4 medium-6 small-12 xSmall-12 margin">
        <label for="user-firstname" class="form-control">
            <span>{{ __('Firstname') }}</span>
            <input id="user-firstname" type="text" name="firstname" value="{{ old('firstname') ?? auth()->user()->firstname }}" required autofocus autocomplete="firstname" />
        </label>
    </div>

    <input type="hidden" name="name" value="{{ old('firstname') ?? auth()->user()->firstname }} {{ strtoupper(old('lastname') ?? auth()->user()->lastname) }}">

    <div class="xLarge-4 large-4 medium-6 small-12 xSmall-12 margin">
        <label for="user-lastname" class="form-control">
            <span>{{ __('Lastname') }}</span>
            <input id="user-lastname" type="text" name="lastname" value="{{ old('lastname') ?? auth()->user()->lastname }}" required autofocus autocomplete="lastname" />
        </label>
    </div>

    <div class="xLarge-4 large-4 medium-6 small-12 xSmall-12 margin">
        <label for="user-email" class="form-control">
            <span>{{ __('Email') }}</span>
            <input id="user-email" type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}" required autofocus />
        </label>
    </div>

    <div class="full">
        <button class="yellow auto" type="submit">
            {{ __('Update Profile') }}
        </button>
    </div>
</form>
