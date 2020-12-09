@extends('layouts.app')
@section('title', 'Moje strony')
@section('content')

  <div class="jumbotron jumbotron-fluid " style="text-align:center">
    <div class="container">
      <h1 class="display-4">Sprawdź nasze artykuły</h1>
      <p class="lead"><a href="/articles" style="color:#212529; text-decoration:none"><button type="button" class="btn btn-dark">Artykuły</button></a></p>
    </div>
  </div>


  <div class="card"  style="text-align:center">
    <div class="card-header">
      Newsletter
    </div>
    <div class="card-body">
      <h5 class="card-title">Zapisz się na nasz Newsletter, aby być z nami na bieżąco!</h5>
      <form action="/newsletter" method="post">
        @csrf
        <div class="form-group" style="  display: flex;  align-items: center;  justify-content: center;">

    <input type="email" name="email" class="form-control w-25" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email" required>

  </div>
  <button type="submit" class="btn btn-primary">Zapisz się</button>
</form>
    </div>
  </div>


@endsection
