@extends('layouts.app')
@section('title')
Rejestracja
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Potwierdź swój adres email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Nowy link aktywacyjny został ponownie wysłany na Twój adres email.') }}
                        </div>
                    @endif

                    {{ __('Proszę sprawdzić skrzynkę pocztową w celu aktywacji konta.') }}
                    {{ __('Jeżeli nie otrzymałeś od nas wiadomości') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('kliknik tutaj, aby wysłać link ponownie') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
