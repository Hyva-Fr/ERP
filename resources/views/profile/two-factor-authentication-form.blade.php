@if(! auth()->user()->two_factor_secret)
    {{-- Enable 2FA --}}
    <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="full section profile-container">
        @csrf
        <h3 class="step-title">{{ __('Two factor authentication') }}</h3>
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
            <label for="user-confirmable-password" class="form-control">
                <span>{{ __('Password') }}</span>
                <input id="user-confirmable-password" type="password" name="confirmable_password" required autocomplete="new-password" />
            </label>
        </div>

        <button class="yellow auto" type="submit">
            {{ __('Enable Two-Factor') }}
        </button>
    </form>
@else
    <div class="profile-container">
        <h3 class="step-title">{{ __('Two factor authentication') }}</h3>
    {{-- Disable 2FA --}}
        <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="full">
            @csrf
            @method('DELETE')
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

            <button class="yellow auto" type="submit">
                {{ __('Disable Two-Factor') }}
            </button>
        </form>

        @if(session('status') == 'two-factor-authentication-enabled')
            {{-- Show SVG QR Code, After Enabling 2FA --}}
            <p class="partials">
                {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
            </p>

            <div class="qr-code-container">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>
        @endif

        {{-- Show 2FA Recovery Codes --}}
        <p class="partials">
            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
        </p>

        <div>
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                <p class="partials">{{ $code }}</p>
            @endforeach
        </div>

        {{-- Regenerate 2FA Recovery Codes --}}
        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}" class="full">
            @csrf
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

            <button class="yellow auto" type="submit">
                {{ __('Regenerate Recovery Codes') }}
            </button>
        </form>
    </div>
@endif
