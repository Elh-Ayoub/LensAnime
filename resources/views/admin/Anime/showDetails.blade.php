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
  <style>.category{background: #2d3748;width: fit-content;padding: 7px 15px;text-align: center;border-radius: 15px;color: white;margin: 5px;}
  .bar { width:0%; height: 100px; } .percent {position:absolute; display:inline-block; left:50%; color: #040608; background: none;}</style>
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
          <button class="btn btn-primary ml-2 mb-3" data-toggle="modal" data-target="#modal-add-episode"><i class="fas fa-plus mr-2"></i>Add episode</button>
          <a href="{{route('animes.edit.view', $anime->id)}}" class="btn btn-warning ml-2 mb-3"><i class="fas fa-pen mr-2"></i>Update Anime info</a>
          <a type="button" class="btn btn-danger ml-2 mb-3" data-toggle="modal" data-target="#modal-delete-anime"><i class="fas fa-times mr-2"></i>delete Anime</a>
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
                  <div class="row justify-content-center mb-3 align-content-center">
                    @foreach(explode(" ", $anime->categories) as $cat)
                      <div class="category">
                        {{$cat}}
                      </div>
                    @endforeach
                  </div>
                  <div class="mb-3 d-flex w-100 justify-content-around align-content-center">
                    <a href="#"><i class="far fa-thumbs-up"></i>Like</a>
                    <a href="#"><i class="far fa-thumbs-down"></i>Dislike</a>
                  </div>
                  <div class="row justify-content-center w-auto pb-3">
                    <div class="mr-2">Created by:</div>
                    <div><img class="img-circle img-sm img-bordered" src="{{\App\Models\User::find($anime->created_by)->profile_photo}}" alt="avatar"><span class="text-bold ml-1">{{\App\Models\User::find($anime->created_by)->username}}</span></div>
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
                  <div class="row d-flex flex-row justify-content-start">
                    @foreach($episodes as $ep)
                      <div class="card col-sm mr-2" style="width: 10rem;">
                        <img class="card-img-top" src="{{$anime->image}}" alt="Card image cap">
                        <div class="card-body">
                          <p>{{$ep->title}}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
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
    <div class="modal fade" id="modal-delete-anime">
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
    <div class="modal fade" id="modal-add-episode">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add episode</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ep-form" action="{{route('episode.create', ['anime_id' => $anime->id])}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" maxlength="40">
                </div>
                <div class="form-group">
                    <label for="description">Description <span class="small">(optional)</span></label>
                    <textarea type="text" id="description" name="description" class="form-control" maxlength="500"></textarea>
                </div>
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#byVideo" data-toggle="tab">Import episode Video</a></li>
                    <li class="nav-item"><a class="nav-link" href="#byLink" data-toggle="tab">Import by link</a></li>            
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="byVideo">
                      <label for="video">Import episode Video</label>
                      <input type="file" id="video" name="video" class="form-control">
                  </div>
                </div>
              </div>
              <div class="progress mt-2">
                <div class="bar bg-blue"></div>
                <div class="percent text-bold">0%</div>
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
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
$(function() {
    $(document).ready(function()
    {
      var bar = $('.bar');
      var percent = $('.percent');
        $('#ep-form').ajaxForm({
          beforeSend: function() {
              var percentVal = '0%';
              bar.width(percentVal)
              percent.html(percentVal);
          },
          uploadProgress: function(event, position, total, percentComplete) {
              var percentVal = percentComplete + '%';
              bar.width(percentVal)
              percent.html(percentVal);
          },
          complete: function(xhr) {
              alert('File Has Been Uploaded Successfully');
              location.reload();
          }
        });
    }); 
 });
</script>
</body>
</html>
