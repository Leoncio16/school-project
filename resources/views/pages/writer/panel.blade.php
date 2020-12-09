@extends('layouts.app')
@section('title', 'Panel pisarza')
@section('content')
<ul class="nav justify-content-center border border-second">
  <li class="nav-item">
    <a class="nav-link active" href="/writer/posts">Moje posty</a>
  </li>
</ul>
<div class="container" style="margin-top:40px">
<h1 class="display-4">
@yield('panel')
</h1>
</div>
@endsection
