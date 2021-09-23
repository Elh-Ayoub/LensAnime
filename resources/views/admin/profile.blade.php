<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Profile | {{env('APP_NAME')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_transparent.png')}}"/>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('admin.layout.navmenu')
    @include('admin.layout.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if(Session::get('success'))
        <div class="alert alert-success col-sm-3 ml-2 text-center" role="alert">
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::get('fail'))
        <div class="alert alert-danger col-sm-3 ml-1" role="alert">
            {{Session::get('fail')}}
            </div>
        @endif
            @if(Session::get('fail-arr'))
            <div class="alert alert-danger col-sm-3 ml-1" role="alert">
                @foreach(Session::get('fail-arr') as $key => $err)
                <p>{{$key . ': ' . $err[0]}}</p>
                @endforeach
            </div>
    @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img id="profile-pic" class="profile-user-img img-fluid img-circle"
                       src="{{$user->profile_photo}}"
                       alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{$user->username}}</h3>
                <p class="text-muted text-center">{{$user->full_name}}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Role</b> <a class="float-right">{{$user->role}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Rating</b> <a class="float-right">{{$user->rating}}</a>
                    </li>
                    <form action="{{route('admin.update.avatar')}}" method="POST" class="form-group row" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex w-100 justify-content-between mt-2 ml-1 mr-2">
                            <label class="">Profile picture</label>
                            <label class="selectfile btn btn-primary" for="choosefile">Edit picture</label>
                            <input id="choosefile" type="file" name="image" class="d-none"> 
                        </div>
                        <button class="btn btn-warning">save</button>
                    </form> 
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col --> 
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Info</a></li>
                    <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>            
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form id="infoForm" action="{{route('admin.update', $user->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="inputLogin" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="inputLogin" placeholder="username" value="{{$user->username}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputfull_name" class="col-sm-2 col-form-label">Full name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputfull_name" name="full_name" placeholder="Full name" value="{{$user->full_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputRole" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select id="inputRole" name="role" class="form-control custom-select">
                                        <option selected disabled>{{$user->role}}</option>
                                        <option>admin</option>
                                        <option>user</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="form-group d-flex justify-content-between">
                            <div class="offset-sm-2">
                            <button id="SubmitInfoForm" type="submit" class="btn btn-success">Save</button>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-user">Delete</button>
                        </div>           
                    </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-delete-user">
        <div class="modal-dialog">
            <form action="{{route('users.delete', $user->id)}}" method="POST" class="modal-content bg-danger">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Delete account</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You're about to delete your account. Are you sure ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-light">Delete</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  @include('admin.layout.footer')
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script>
function readImage(input) {
  if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#profile-pic').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#choosefile").change(function(){
    readImage(this);
});
$('#SubmitInfoForm').click(function(){
    $('#infoForm').submit();
})
</script>
</body>
</html>
