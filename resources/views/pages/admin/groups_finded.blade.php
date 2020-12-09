@extends('pages.admin')
@section('panel')

<h4 class="display-4 float-left">Grupa: <?php echo substr($role, 2, -2);?> </h3>
<h3 class="display-4 float-right"><a class="nav-link" href="/admin/users"><button type="button" class="btn btn-success">Powrót do wszystkich użytkowników</button></a></h3>
<table class="table" style="text-align:center; ">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">nazwa</th>
      <th scope="col">email</th>
      <th scope="col">created</th>
      <th scope="col">updated</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user => $data)
    <tr>
     <th scope="row">{{$data->users_id}}</th>
     <td>{{$data->name}}</td>
     <td>{{$data->email}}</td>
     <td>{{$data->created_at}}</td>
     <td>{{$data->updated_at}}</td>
     <td>

     </td>
   </tr>
    @endforeach


  </tbody>
</table>

  @endsection
