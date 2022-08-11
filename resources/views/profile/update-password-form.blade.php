<form method="POST" action="{{ route('user-password.update') }}" class="section profile-container">
    @csrf
    @method('PUT')
    <h3 class="step-title">{{ __('Update password') }}</h3>
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

    <div class="xLarge-4 large-4 medium-6 small-12 xSmall-12 margin">
        <label for="user-current_password" class="form-control">
            <span>{{ __('Current Password') }}</span>
            <input id="user-current-password" type="password" name="current_password" required autocomplete="current-password" />
        </label>
    </div>

    <div class="xLarge-4 large-4 medium-6 small-12 xSmall-12 margin">
        <label for="user-password" class="form-control">
            <span>{{ __('Password') }}</span>
            <input id="user-password" type="password" name="password" required autocomplete="new-password" />
        </label>
    </div>

    <div class="xLarge-4 large-4 medium-6 small-12 xSmall-12 margin">
        <label for="user-password_confirmation" class="form-control">
            <span>{{ __('Confirm Password') }}</span>
            <input id="user-password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
        </label>
    </div>

    <div class="full">
        <button class="yellow auto" type="submit">
            {{ __('Save') }}
        </button>
    </div>
</form>
