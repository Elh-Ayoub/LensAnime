<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_transparent.png')}}"/>
  <title>{{$anime->title}} Ep-{{$episode->number}} | {{env('APP_NAME')}}</title>
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
            <h1>{{$anime->title}} - Ep-{{$episode->number}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{route('animes.details', $anime->id)}}">{{$anime->title}}</a></li>
              <li class="breadcrumb-item active">Ep-{{$episode->number}}</li>
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
          <a type="button" class="btn btn-warning ml-2 mb-3" data-toggle="modal" data-target="#modal-update-ep"><i class="fas fa-pen mr-2"></i>Update episode</a>
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
                        <div class="tab-content" style="height: 50vh;overflow-y: scroll;">
                            <div class="active tab-pane" id="eps">
                                <ul class="nav nav-pills flex-column">
                                    @foreach($all_episodes as $ep)
                                    <li class="nav-item text-bold text-center  p-2 mb-1 @if($ep->number === $episode->number) bg-primary @else bg-secondary @endif">
                                        <a href="{{route('episode.details', $ep->id)}}">Episode - {{$ep->number}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-pane" id="servers">
                                <ul class="nav nav-pills flex-column">
                                @foreach($servers as $server)
                                    <li class="nav-item text-bold text-center bg-secondary p-2 server-link mb-1" data-src="{{explode(' | ', $server)[1]}}" style="cursor: pointer;">
                                        {{explode(" | ", $server)[0]}}
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
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
                <h4 class="modal-title">Delete episode</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You're about to delete an episode. Are you sure ?</p>
            </div>
            <form action="{{route('episode.delete', $episode->id)}}" method="POST">
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
    <div class="modal fade" id="modal-update-ep">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update episode</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ep-form" action="{{route('episode.update', $episode->id)}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="modal-body">
                <div class="form-group">
                    <label for="number">Episode number</label>
                    <input type="number" id="number" name="number" class="form-control" value="{{$episode->number}}">
                </div>
                <div class="form-group">
                    <label for="description">Description <span class="small">(optional)</span></label>
                    <textarea type="text" id="description" name="description" class="form-control" maxlength="500">{{$episode->description}}</textarea>
                </div>
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="#byLink" data-toggle="tab">Import by Embed src link</a></li>            
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane server_links" id="byLink">
                    @foreach($servers as $server)
                    <div class="d-flex">
                      <input type="text" id="server_name" name="server_name[]" class="form-control" placeholder="server name" style="width: 35%;" value='{{explode(" | ", $server)[0]}}'>
                      <input type="text" id="src" name="src[]" class="form-control" placeholder="Embed code src link" value='{{explode(" | ", $server)[1]}}'>
                      <div class="btn btn-danger" id="remove_server" onClick="$(this).parent().remove();"><i class="fas fa-trash"></i></div>
                    </div>
                    @endforeach
                  </div>
                  <div type="button" id="add_ep_server" class="btn btn-success mt-2">Add server</div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-warning">Save</button>
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
    $(function() {
        $('#add_ep_server').click(function(){
        var row = '<div class="d-flex added_server">'+
                        '<input type="text" id="server_name" name="server_name[]" class="form-control" placeholder="server name" style="width: 35%;">'+
                        '<input type="text" id="src" name="src[]" class="form-control" placeholder="Embed code src link">'+
                        '<div class="btn btn-danger" id="remove_server" onClick="$(this).parent().remove();"><i class="fas fa-trash"></i></div></div>'
        $('.server_links').append(row)
        })
    });
})
</script>
</body>
</html>
