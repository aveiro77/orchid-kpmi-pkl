<div class="mb-3">
    <label for="email" class="form-label text-secondary fw-medium small mb-1">
        {{ __('Email address') }}
    </label>

    <div class="input-group">
        <span class="input-group-text bg-light border-end-0 text-muted">
            <x-orchid-icon path="bs.envelope" />
        </span>
        <input type="email"
               name="email"
               id="email"
               class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               required
               tabindex="1"
               autofocus
               autocomplete="email"
               inputmode="email"
               placeholder="{{ __('Enter your email') }}">
    </div>
    @error('email')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label text-secondary fw-medium small mb-1">
        {{ __('Password') }}
    </label>

    <div class="input-group">
        <span class="input-group-text bg-light border-end-0 text-muted">
            <x-orchid-icon path="bs.lock" />
        </span>
        <input type="password"
               name="password"
               id="password"
               class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
               required
               tabindex="2"
               autocomplete="current-password"
               placeholder="{{ __('Enter your password') }}">
    </div>
    @error('password')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="form-check">
        <input type="hidden" name="remember" value="false">
        <input type="checkbox"
               name="remember"
               id="remember"
               value="true"
               class="form-check-input"
               {{ !old('remember') || old('remember') === 'true' ? 'checked' : '' }}>
        <label for="remember" class="form-check-label small text-muted">
            {{ __('Remember Me') }}
        </label>
    </div>
</div>

<div class="d-grid">
    <button id="button-login" type="submit" class="btn btn-primary py-2 fw-semibold" tabindex="3">
        <x-orchid-icon path="bs.box-arrow-in-right" class="me-2"/>
        {{ __('Login') }}
    </button>
</div>
