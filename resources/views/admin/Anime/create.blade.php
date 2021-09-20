<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/Logo.png')}}"/>
  <title>Create User - {{env('APP_NAME')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/chip.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include('admin.layout.navmenu')
    @include('admin.layout.sidebar')
  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create anime</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create anime</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <form method="POST" action="{{route('create.user')}}" class="card p-3" enctype="multipart/form-data">
        <div class="d-flex align-items-stretch flex-row">
            <div class="col-md-6">
                <div class="card card-primary p-2">
                    @csrf
                        <div class="card-header">
                        <h3 class="card-title">General</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="card-body">
                        @if(Session::get('success'))
                            <div class="form-group">
                                <p class="success">{{Session::get('success')}}</p>
                            </div>
                        @endif
                        @if(Session::get('fail'))
                            <div class="form-group">
                                <p class="fail">{{Session::get('fail')}}</p>
                            </div>
                        @endif
                        @if(Session::get('fail-arr'))
                            <div class="input-field">
                                @foreach(Session::get('fail-arr') as $key => $err)
                                <p class="fail">{{$key . ': ' . $err[0]}}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" id="description" name="description" class="form-control" maxlength="500"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <div id="res"></div>
                            <input type="text" id="categories" name="categories" class="form-control" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="image">Main image</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="episodes_num">Number of episodes <span class="small">(optional)</span></label>
                            <input type="number" id="episodes_num" name="episodes_num" min="1" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="episode_duration">Episodes duration - By minutues<span class="small">(optional)</span></label>
                            <input type="number" id="episode_duration" name="episode_duration" min="1" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                    <a href="{{route('animes.list')}}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Create" class="btn btn-success float-right">
                    </div>
                </div>
            </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
  </div>
  @include('admin.layout.footer')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="{{ asset('js/chip.js') }}"></script>
</body>
</html>
