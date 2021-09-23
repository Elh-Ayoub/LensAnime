<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anime list | {{env('APP_NAME')}}</title>

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
            <h1>Animes list</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Animes list</li>
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
        <a href="{{route('animes.create.view')}}" class="btn btn-primary col-sm-2"><i class="fas fa-plus"></i>Add anime</a>
            <div class="row mt-3 d-felx flex-row">
              @foreach($animes as $anime)
                <div class="col-sm">
                  <div class="card" style="width: 18rem;">
                      <img class="card-img-top" src="{{$anime->image}}" alt="Card image cap">
                      <div class="card-body">
                          <h5 class="card-title">{{$anime->title}}</h5>
                          <p class="card-text">{{$anime->description}}</p>
                          <a href="{{route('animes.details', $anime->id)}}" class="btn btn-primary">Details</a>
                      </div>
                  </div>
                </div>
              @endforeach
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-delete-user">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content bg-danger">
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
