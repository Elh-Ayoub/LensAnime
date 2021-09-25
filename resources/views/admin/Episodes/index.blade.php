<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_transparent.png')}}"/>
  <title>{{$anime->title}} - {{$episode->title}} | {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/chip.css')}}">
  <link rel="stylesheet" href="{{ asset('css/episode.css')}}">
  <style>.category{background: #2d3748;width: fit-content;padding: 7px 15px;text-align: center;border-radius: 15px;color: white;margin: 5px;}</style>
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
            <h1>{{$anime->title}} - {{$episode->title}}</h1>
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
        <div>
          <a href="#" class="btn btn-warning ml-2 mb-3"><i class="fas fa-pen mr-2"></i>Update episode</a>
          <a type="button" class="btn btn-danger ml-2 mb-3" data-toggle="modal" data-target="#modal-delete-ep"><i class="fas fa-times mr-2"></i>delete episode</a>
        </div>
        <div class="episode-container align-items-start flex-row-reverse justify-content-start">
            <div class="w-100">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe id="episode" class="embed-responsive-item" frameborder="0" src="{{explode(' | ', $servers[0])[1]}}" allowfullscreen></iframe>
                </div>
                <div class="mb-3 d-flex justify-content-start align-content-center">
                    <a href="#" class="m-2"><i class="far fa-thumbs-up"></i>Like</a>
                    <a href="#" class="m-2"><i class="far fa-thumbs-down"></i>Dislike</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="fixed">
                    <div class="card" style="width: 16rem;">
                    <div class="card-body">
                        <h3>{{$anime->title}}</h3>
                        <ul class="nav nav-pills row mb-3 justify-content-between">
                            <li class="nav-item"><a class="nav-link active" href="#eps" data-toggle="tab">Episodes</a></li>            
                            <li class="nav-item"><a class="nav-link" href="#servers" data-toggle="tab">servers</a></li>            
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="eps">
                                <ul class="nav nav-pills flex-column">
                                    @foreach($all_episodes as $ep)
                                    <li class="nav-item text-bold text-center bg-secondary p-2">
                                        <a href="{{route('episode.details', $ep->id)}}">Episode - {{$ep->number}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-pane" id="servers">
                                <ul class="nav nav-pills flex-column">
                                @foreach($servers as $server)
                                    <li class="nav-item text-bold text-center bg-secondary p-2 server-link" data-src="{{explode(' | ', $server)[1]}}" style="cursor: pointer;">
                                        {{explode(" | ", $server)[0]}}
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                        </ul>
                    </div>
                    <div class="row justify-content-center w-auto pb-3">
                        <div class="mr-2">Created by:</div>
                        <div><img class="img-circle img-sm img-bordered" src="{{\App\Models\User::find($episode->created_by)->profile_photo}}" alt="avatar"><span class="text-bold ml-1">{{\App\Models\User::find($episode->created_by)->username}}</span></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="modal-delete-ep">
      <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete anime</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You're about to delete an anime. Are you sure ?</p>
            </div>
            <form action="{{route('animes.delete', $anime->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-light">Delete</button>
                </div>
            </form>
        </div>
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
<script src="{{ asset('js/chip.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $('.server-link').click(function(){
        var url = $(this).data('src')
        $('#episode').attr('src', url)
    })
    
})
</script>
</body>
</html>
