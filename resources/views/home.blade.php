@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Podsumowanie</div>

                <div class="card-body" style="text-align:center;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Akcja zakończona pomyślnie</h3>
                    <a href="/"><button type="button" class="btn btn-primary" style="margin-top:20px;">Powrót</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
