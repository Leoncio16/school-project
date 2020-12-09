@extends('layouts.app')
@section('title', 'Moje strony')
@section('content')
  @foreach($pages as $page)
    {{ $page->tittle }} <br>
  @endforeach
@endsection
