@extends('pages.admin')
@section('panel')

      <h3 class="display-4 float-left">Posty</h3>
      <h3 class="display-4 float-right"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#add">dodaj nowy post</button></h3>
      <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dodawanie</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="/admin/posts/create" method="post">
                    @csrf
                    <input type="hidden" value='admin' name="rola">
                    <div class="form-group">
                      <label for="title">Tytuł</label>
                      <input type="text" name="title" class="form-control" id="title"  aria-describedby="emailHelp" placeholder="Tytuł" required>
                    </div>
                    <div class="form-group">
                      <label for="content">Treść</label>
                      <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="img">Zdjęcie</label>
                      <input type="text" class="form-control" id="img" name="img" aria-describedby="emailHelp" placeholder="Link" required>
                    </div>

                     <input type="hidden" id="autor" name="autor" value="{{ Auth::user()->name }}">



                </div>
                <div class="modal-footer">

                  <button type="submit" class="btn btn-danger">Dodaj</button>
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
        <th scope="col" colspan="5">tytuł</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th scope="col">plus</th>
        <th scope="col">minus</th>
        <th scope="col">akcje</th>
      </tr>
    </thead>
    <tbody>
      @foreach($articles->sortBy('id') as $article => $data)
      <tr>
        <th scope="row">{{ $data-> id}}</th>
        <td colspan="5">{{$data->tittle}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{$data->plus}}</td>
        <td>{{$data->minus}}</td>
        <td>
          <button class="btn btn-primary" data-toggle="modal" data-target="#more{{$data->id}}">szczegóły</button>

          <div class="modal fade" id="more{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">szczegóły</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <h4>{{$data->tittle}}</h4>
                      <hr>
                      <p>{{$data->content}}</p>
                      <hr>
                      <img src="{{$data->img}}" width="50%">
                      <hr>
                      <p>Autor: {{$data->autor}}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    </div>
                    </div>
                  </div>
          </div>

          <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#edit{{$data->id}}">edytuj</button>

          <div class="modal fade" id="edit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="text-align:left;">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tryb edycji</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="edit_data" action="/admin/posts/edit" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="title_edit">Tytuł</label>
                          <input type="text" name="title_edit" class="form-control" id="title_edit"  aria-describedby="emailHelp" value="{{$data->tittle}}" required>
                        </div>
                        <div class="form-group">
                          <label for="content_edit">Treść</label>
                          <textarea class="form-control" id="content_edit" name="content_edit" rows="3" required> {{$data->content}}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="img_edit">Zdjęcie</label>
                          <input type="text" class="form-control" id="img_edit" name="img_edit" aria-describedby="emailHelp" value="{{$data->img}}" required>
                        </div>
                         <input type="hidden" id="post_id" name="post_id" value="{{$data->id}}">
                          </form>


                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                      <button type="submit" class="btn btn-primary" form="edit_data">Zapisz zmiany</button>
                    </div>
                    </div>
                  </div>
</div>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{$data->id}}">usuń</button>
          <div class="modal fade" id="delete{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Usuń</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <h2>Czy napewno chcesz usunąć: "{{$data->tittle}}" ?</h2>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                      <a href="/admin/posts/delete/{{$data->id}}"><button type="button" class="btn btn-danger">Usuń</button></a>
                    </div>
                    </div>
                  </div>
</div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
    {!! $articles->links() !!}
</div>


@endsection
