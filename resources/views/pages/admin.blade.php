@extends('layouts.app')
@section('title', 'Panel administratora')
@section('content')
<ul class="nav justify-content-center border border-second">
  <li class="nav-item">
    <a class="nav-link active" href="/admin/posts">Posty</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/admin/users">Użytkownicy</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/admin/newsletter">Newsletter</a>
  </li>
</ul>
<div class="container" style="margin-top:40px">
<h1 class="display-4">
@yield('panel')
</h1>
</div>
@endsection
