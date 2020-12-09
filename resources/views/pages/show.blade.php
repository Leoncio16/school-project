@extends('layouts.app')
@section('title', $page->tittle)
@section('content')
<h1>{{ $page->tittle }}</h1>
<p>{{ $page->content }}</p>
@endsection
