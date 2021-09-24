<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_transparent.png')}}"/>
  <title>Update anime - {{env('APP_NAME')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/chip.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('admin.layout.navmenu')
    @include('admin.layout.sidebar')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update anime</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create anime</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <form method="POST" action="{{route('animes.update', $anime->id)}}" class="card p-3" enctype="multipart/form-data">
        <div class="d-flex align-items-stretch flex-row">
            <div class="col-md-6">
            @if(Session::get('success'))
                <div class="alert alert-success">
                  {{Session::get('success')}}
                </div>
            @endif
            @if(Session::get('fail'))
                <div class="alert alert-danger">
                  {{Session::get('fail')}}
                </div>
            @endif
            @if(Session::get('fail-arr'))
                <div class="input-field">
                  @foreach(Session::get('fail-arr') as $key => $err)
                  <p class="alert alert-danger">{{$key . ': ' . $err[0]}}</p>
                  @endforeach
                </div>
            @endif
            <div class="card card-primary p-2">
                @csrf
                @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">General</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" maxlength="40" value="{{$anime->title}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="text" id="description" name="description" class="form-control" maxlength="500">{{$anime->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="categories">Categories</label>
                        <div id="res"></div>
                        <input type="text" id="categories" name="categories" class="form-control" maxlength="30" value="{{$anime->categories}}">
                    </div>
                    <div class="form-group">
                        <label for="image">Main image</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="episodes_num">Number of episodes <span class="small">(optional)</span></label>
                        <input type="number" id="episodes_num" name="episodes_num" min="1" class="form-control" value="{{$anime->episodes_num}}">
                    </div>
                    <div class="form-group">
                        <label for="episode_duration">Episodes duration - By minutues<span class="small">(optional)</span></label>
                        <input type="number" id="episode_duration" name="episode_duration" min="1" class="form-control" value="{{$anime->episode_duration}}">
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{route('animes.details', $anime->id)}}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Save" class="btn btn-warning float-right">
                </div>
            </div>
            </div>
        </div>
      </form>
    </section>
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
<script src="{{ asset('js/chip.js') }}"></script>
</body>
</html>
