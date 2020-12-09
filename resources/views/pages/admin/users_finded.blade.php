@extends('pages.admin')
@section('panel')
@foreach($users as $user => $data)
<h3 class="display-4 float-left">Użytkownik</h3>
<h3 class="display-4 float-right"><a class="nav-link" href="/admin/users"><button type="button" class="btn btn-success">Powrót do wszystkich użytkowników</button></a></h3>
<table class="table" style="text-align:center; ">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">nazwa</th>
      <th scope="col">email</th>
      <th scope="col">grupy</th>
      <th scope="col">created</th>
      <th scope="col">updated</th>
      <th scope="col">akcje</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">{{$data->id}}</th>
      <td>{{$data->name}}</td>
      <td>{{$data->email}}</td>
      <td>
        <?php

        for($i=1; $i<=$count_score; $i++){
          if(isset($user_roles[$i])){
            echo substr($user_roles[$i], 2, -2)."<br>";
          }
        }

         ?>

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
                            <form id="edit_data" action="/admin/users/edit" method="post">
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
                              @foreach($user_roles_all as $user_role_all => $data2)
                              <?php
                              if($data->id==$data2->users_id){
                              ?>
                              @foreach($roles_all as $role => $data3)
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
                              @foreach($roles_all as $role_all => $data2)

                              <div class="form-check">

                                <input class="form-check-input" type="radio" name="addRadios" id="{{$data2->name}}_add" value="{{$data2->id}}">
                                  <label class="form-check-label" for="{{$data2->name}}_add">
                                    {{$data2->name}}
                                  </label>

                              </div>

                              @endforeach





                            </form>


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            <button type="submit" class="btn btn-primary" form="edit_data">Zapisz zmiany</button>
                          </div>
                          </div>
                        </div>
                      </div>

      </td>
    </tr>
    <tr>

  </tbody>
</table>
@endforeach
@endsection
