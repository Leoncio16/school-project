@extends('pages.admin')
@section('panel')
<h4 class="display-4 float-left">Newsletter</h4>
<h4 class="display-4 float-right">
<button type="button" class="btn btn-warning " data-toggle="modal" data-target="#new">Wyślij nowy newsletter</button>
</h4>
<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dodawanie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/admin/newsletter/create" method="post">
              @csrf
              <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" name="title" class="form-control" id="title"  aria-describedby="emailHelp" placeholder="Tytuł" required>
              </div>
              <div class="form-group">
                <label for="content">Treść</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
              </div>

               <input type="hidden" id="autor" name="autor" value="{{ Auth::user()->name }}">
               <input type="hidden" id="email" name="mail" value="moja.aplikacja.mail@gmail.com">


          </div>
          <div class="modal-footer">

            <button type="submit" class="btn btn-success">Wyślij</button>
              </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

          </div>
          </div>
        </div>
      </div>
      <table class="table" style="text-align:center">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">tytuł</th>
            <th scope="col">Treść</th>
            <th scope="col">Wysłano</th>
          </tr>
        </thead>
        <tbody>
          @foreach($mails_sended as $mail_sended => $data)
          <tr>
            <th scope="row">{{$data->id}}</th>
            <td>{{$data->title}}</td>
            <td>{{$data->content}}</td>
            <td>{{$data->created_at}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {!! $mails_sended->links() !!}
    </div>
@endsection
