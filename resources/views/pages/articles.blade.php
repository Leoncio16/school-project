@extends('layouts.app')
@section('title')
Artykuły
@endsection
@section('content')
<?php
  $open = session('open');
  if(isset($open)){ ?>
    <script type='text/javascript'>
    $(function() {
   $("#comments"+<?php echo $open; ?>).modal("show");
   });
   function editform(id){
     $('#editform'+id).show();
   }
   function myFunction() {
  alert("test");
}
</script>
  <?php
  }
 ?>
<h1>Nasze artykuły:<h1>

  @foreach($articles->sortByDesc('plus') as $article => $data)


<div class="jumbotron jumbotron-fluid" style="text-align:center;">
  <div class="container">
    <div class="row">
    @if ($logged && Auth::user()->email_verified_at !== null)
      <div class="col-2">
        <a style="color:#212529; text-decoration:none;" href="/plus/{{$data->id}}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
        </svg>
      </a>
        <br>
        <a style="color:#212529; text-decoration:none;" href="/minus/{{$data->id}}">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
        </svg>
      </a>
        <br>
        <p style="font-size:2rem"><span class="text-success">{{$data->plus}}</span>:<span class="text-danger">{{$data->minus}}</span></p>
      </div>
      @else
      <div class="col-2"></div>

      @endif


      <div class="col-8">
    <h2 class="display-4">{{$data->tittle}}</h2>
    <p class="lead">{{$data->content}}</p>
</div>
<div class="col-2 ">
    <img src="{{$data->img}}" width="100%" alt="{{$data->tittle}}" class="img-thumbnail d-flex justify-content-center">
</div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#read{{$data->id}}">Czytaj dalej</button>

<div class="modal fade" id="read{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{$data->tittle}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{$data->content}}</p>
            <br>
            <img src="{{$data->img}}" width="50%">
            <p><small>Autor: {{$data->autor}}</small></p>

          </div>
          <div class="modal-footer">
            @if ($logged && Auth::user()->email_verified_at !== null)
            <div class="mr-auto">
            <a style="color:#212529; text-decoration:none;" href="/plus/{{$data->id}}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
            </svg>
          </a>
          <a style="color:#212529; text-decoration:none;" href="/minus/{{$data->id}}">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
          </svg>
        </a>
        <span style="font-size:2rem"><span class="text-success">{{$data->plus}}</span>:<span class="text-danger">{{$data->minus}}</span></span>
      </div>

      <button type="button" class="btn btn-info" data-dismiss="modal" data-toggle="modal" href="#comments{{$data->id}}">Komentarze</button>

      @endif


     <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

          </div>

          </div>
        </div>
</div>
  </div>

</div>
@if ($logged)
<div class="modal fade" style="overflow-y:auto;" id="comments{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Komentarze "{{$data->tittle}}"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="margin-bottom: 80px">
        <form action="/comments/add" method="post">
          @csrf
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Napisz komentarz</span>
            </div>
            <textarea class="form-control" name="comment" aria-label="With textarea" required></textarea>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id}}">
            <input type="hidden" name="user_name" value="{{ Auth::user()->name}}">
            <input type="hidden" name="card_id" value="{{$data->id}}">
          </div>
          <button type="submit" class="btn btn-primary float-right" style="margin-top: 20px">dodaj</button>
        </form>
</div>
        @foreach($comments->sortByDesc('created_at') as $comment => $data2)
        <?php
        if($data->id == $data2->cards_id){
         ?>
        <div class="card" style="margin-bottom:20px; position: relative;">
            <div class="card-body">

              <?php
              if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator')){ ?>
                <a style="color:grey;" href='/comments/delete/{{$data2->id}}' ><svg style="position: absolute;top: 0.3em; right: 0.3em; left: auto; display:block;" width="0.5em" height="0.5em" viewBox="0 0 16 16" class="bi bi-x-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                </svg></a>
                <svg onclick="editform({{$data2->id}})" style="position: absolute;top: 0.3em; right: 1em; left: auto; display:block;" width="0.5em" height="0.5em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
                <script>
                function editform(id){
                  $('#editform'+id).toggle();
                }
             </script>
                <?php
              } else if($data2->users_id == Auth::user()->id){ ?>
                <a style="color:grey;" href='/comments/delete/{{$data2->id}}' ><svg style="position: absolute;top: 0.3em; right: 0.3em; left: auto; display:block;" width="0.5em" height="0.5em" viewBox="0 0 16 16" class="bi bi-x-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                </svg></a>
                <svg <svg onclick="editform({{$data2->id}})" style="position: absolute;top: 0.3em; right: 1em; left: auto; display:block;" width="0.5em" height="0.5em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
                <script>
                function editform(id){
                  $('#editform'+id).toggle();
                }
             </script>
                <?php
              }
               ?>




          <h4>{{$data2->users_name}}</h4>
          <p style="font-size:1rem;" id="com{{$data2->id}}">{{$data2->comments}}</p>

          <form style="display:none" id="editform{{$data2->id}}" action="/comments/edit" method="post">
            @csrf
            <input type="hidden" value="{{$data2->id}}" name="comment_id">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><button type="submit" class="btn btn-primary">Edytuj komentarz</button></span>
              </div>
              <textarea class="form-control" name="edited_com" >{{$data2->comments}}</textarea>
            </div>
          </form>

          <div style="text-align:right">
           <small style="font-size:1rem;"class="form-text text-muted">{{$data2->created_at}}</small>
         </div>
      </div>
      </div>
    <?php } ?>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" data-toggle="modal" href="#read{{$data->id}}">Wróc do artykułu</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>
@endif
  @endforeach

@endsection
