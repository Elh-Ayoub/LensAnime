<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_transparent.png')}}"/>
  <title>{{$anime->title}} - {{env('APP_NAME')}}</title>
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
            <h1>{{$anime->title}}</h1>
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
      <div>
        <div>
          <button class="btn btn-primary ml-2 mb-3"><i class="fas fa-plus mr-2"></i>Add episode</button>
          <a href="{{route('animes.edit.view', $anime->id)}}" class="btn btn-warning ml-2 mb-3"><i class="fas fa-pen mr-2"></i>Update Anime info</a>
        </div>
        <div class="d-flex align-items-start flex-row justify-content-start">
          <div class="col-sm">
              <div class="fixed">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{$anime->image}}" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title text-bold text-lg text-center w-100 mb-2">{{$anime->title}}</h5>
                    <div class="w-75 d-flex justify-content-between align-content-center m-auto">
                      <span class="text-bold text-purple">Rating :</span><span>{{$anime->rating}}</span>
                    </div>
                    <div class="w-75 d-flex justify-content-between align-content-center m-auto">
                      <span class="text-bold text-purple">Number of episodes :</span><span>{{$anime->episodes_num ? ($anime->episodes_num) : ("?")}}</span>
                    </div>
                    <div class="w-75 d-flex justify-content-between align-content-center m-auto">
                      <span class="text-bold text-purple">Duration of episodes :</span><span>{{$anime->episode_duration ? ($anime->episode_duration) : ("?")}}</span>
                    </div>
                  </div>
                  <div class="mb-3 d-flex w-100 justify-content-around align-content-center">
                    <a href="#"><i class="far fa-thumbs-up"></i>Like</a>
                    <a href="#"><i class="far fa-thumbs-down"></i>Dislike</a>
                  </div>
                </div>
              </div>
          </div>
          <div class="w-100">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#episodes" data-toggle="tab">Episodes</a></li>
                  <li class="nav-item"><a class="nav-link" href="#comments" data-toggle="tab">Comments(0)</a></li>            
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="episodes">
                  <div>Episodes coming soon!</div>
                </div>
                <div class="tab-pane" id="comments">
                  <div>Comments coming soon!</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
