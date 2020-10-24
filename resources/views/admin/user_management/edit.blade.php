@extends('admin.layouts.master')

@section('title', 'Edit User')

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">User</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{url('admin/users/update')}}/{{$user->id}}" method="post">
                @csrf
                {{method_field('POST')}}
                <div class="form-group row">
                  <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                  <div class="col-md-6">
                    <input type="name" id="name" name="name" class="form-control" value="{{$user->name}}" required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name" class="col-md-4 col-form-label text-md-right">Email address</label>
                  <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control" value="{{$user->email}}" required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="roles" class="col-md-4 col-form-label text-md-right">Roles</label>
                  <div class="col-md-6">
                    @foreach($roles as $role)
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="{{$role->id}}" name="roles[]" value="{{$role->id}}" @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
                        <label class="form-check-label">{{$role->role_name}}</label>
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="form-group row mb-0">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
@stop