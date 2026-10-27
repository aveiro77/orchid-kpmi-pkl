@extends('platform::auth')

@section('title', __('Sign in to your account'))

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger mb-4 py-2 px-3 small rounded-3" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="false"
          data-action="form#submit"
          action="{{ route('platform.login.auth') }}">
        @csrf

        @includeWhen($isLockUser, 'platform::auth.lockme')
        @includeWhen(! $isLockUser, 'platform::auth.signin')
    </form>
@endsection
