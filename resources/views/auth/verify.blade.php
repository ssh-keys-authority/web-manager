@extends('layouts.app')

@section('content')
    <div class="alert alert-danger">
        <h4 class="alert-heading">Подвердите вашу электронную почту!</h4>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p>Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.</p>

        <hr>

        Если вы не получили письмо,
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0">нажмите здесь, чтобы запросить новое
            </button>
        </form>
    </div>
@endsection
