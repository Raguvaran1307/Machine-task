@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Permissions</h2>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if($user->roles == 1)
        Admin
      @else
        User
      @endif
    </td>
    <td>
       <a class="btn btn-primary" href="JavaScript:void(0);" onclick="approve({{$user->id}})">approve</a>
       <a class="btn btn-danger" href="JavaScript:void(0);" onclick="reject({{$user->id}})">reject</a>
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}


@endsection
