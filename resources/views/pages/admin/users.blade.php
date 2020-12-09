
@extends('pages.admin')
@section('panel')

<h3 class="display-4 float-left">Użytkownicy</h3>
<h3 class="display-4 float-right"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#find">Znajdź użytkownika</button></h3>
<div class="modal fade" id="find" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Wyszukiwarka</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/admin/users/find" id="find_user" method="post">
              @csrf
              <div class="form-group">
                <label for="user_id">Id użytkownika: </label>
                <input type="number" name="user_id" class="form-control" id="user_id" aria-describedby="user_id">
              </div>
              <div class="form-group">
                <label for="user_name">Nazwa użytkownika: </label>
                <input type="text" name="user_name" class="form-control" id="user_name" aria-describedby="user_name">
              </div>
              <div class="form-group">
                <label for="user_email">Email użytkownika: </label>
                <input type="text" name="user_email" class="form-control" id="user_email" aria-describedby="user_email">
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <div class="mr-auto">
              <form action="/admin/users/find_group" id='find_group' method="post">
                @csrf
                <div class="form-group">
                  <select class="form-control" id="Role" name="select_role">
                  @foreach($roles as $role => $datarole)
                    <option value="{{$datarole->id}}">{{$datarole->name}}</option>
                    @endforeach
                  </select>
                </div>
              </form>
            <button type="submit" form="find_group" class="btn btn-dark">Znajdź po grupie</button>
          </div>
            <button type="submit" class="btn btn-success" form="find_user">Znajdź</button>
              </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

          </div>
          </div>
        </div>
      </div>



<table class="table" style="text-align:center;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">nazwa</th>
      <th scope="col">email</th>
      <th scope="col">Grupy</th>
      <th scope="col">created</th>
      <th scope="col">updated</th>
      <th scope="col">akcje</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user => $data)
    <tr>
      <th scope="row">{{$data->id}}</th>
      <td>{{$data->name}}</td>
      <td>{{$data->email}}</td>
      <td>
        @foreach($user_roles as $user_role => $data2)
        <?php
        if($data->id==$data2->users_id){

        ?>
        @foreach($roles as $role => $data3)
          <?php
            if($data3->id==$data2->roles_id){
              echo $data3->name."<br>";
            }
           ?>
        @endforeach
        <?php
      }
         ?>
        @endforeach

      </td>
      <td>{{$data->created_at}}</td>
      <td>{{$data->updated_at}}</td>
      <td>
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
                    <h2>Czy napewno chcesz usunąć użytkownika: "{{$data->name}}" ?</h2>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <a href="/admin/users/delete/{{$data->id}}"><button type="button" class="btn btn-danger">Usuń</button></a>
                  </div>
                  </div>
                </div>
              </div>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{$data->id}}">edytuj</button>
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
                    <form id="edit_data_{{$data->name}}" action="/admin/users/edit" method="post">
                      @csrf
                      <input type="hidden" name="actual_user" value="{{$data->id}}">
                      <div class="form-group">
                        <label for="nazwa">Nazwa:</label>
                        <input type="text" name='name' class="form-control" id="nazwa" aria-describedby="nazwa" value="{{$data->name}}">
                        <input type="hidden" name="before_name" value="{{$data->name}}">
                      </div>
                      <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" id="email" aria-describedby="email" value="{{$data->email}}">
                      </div>
                      <p>usuń role:</p>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="removeRadios" id="notmove_remove" value="0" checked>
                          <label class="form-check-label" for="notmove_remove">
                            Brak akcji
                          </label>
                      </div>
                      @foreach($user_roles as $user_role => $data2)
                      <?php
                      if($data->id==$data2->users_id){

                      ?>
                      @foreach($roles as $role => $data3)
                        <?php
                          if($data3->id==$data2->roles_id&&$data3->name!='User'){
                            ?>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="removeRadios" id="{{$data3->name}}_remove" value="{{$data3->id}}">
                                <label class="form-check-label" for="{{$data3->name}}_remove">
                                  {{$data3->name}}
                                </label>
                            </div>
                            <?php
                          }
                         ?>
                      @endforeach
                      <?php
                    }
                       ?>
                      @endforeach

                      <br>
                      <p>dodaj role:</p>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="addRadios" id="notmove_add" value="0" checked>
                          <label class="form-check-label" for="notmove_add">
                            Brak akcji
                          </label>
                      </div>
                      @foreach($roles as $role => $data9)

                      <div class="form-check">

                        <input class="form-check-input" type="radio" name="addRadios" id="{{$data9->name}}_add" value="{{$data9->id}}">
                          <label class="form-check-label" for="{{$data9->name}}_add">
                            {{$data9->name}}
                          </label>

                      </div>

                      @endforeach





                    </form>


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary" form="edit_data_{{$data->name}}">Zapisz zmiany</button>
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
  {!! $users->links() !!}
</div>
@endsection
