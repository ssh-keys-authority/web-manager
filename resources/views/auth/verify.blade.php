@extends('layouts.app')

@section('content')
    <div class="alert alert-danger">
        <h4 class="alert-heading">{{ __('Verify your email!') }}</h4>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address') }}
            </div>
        @endif

        <p>{{ __('Before proceeding, check your email for a confirmation link') }}</p>

        <hr>

        {{ __('If you have not received the letter') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0">{{ __('click here to request a new') }}</button>
        </form>
    </div>
@endsection
