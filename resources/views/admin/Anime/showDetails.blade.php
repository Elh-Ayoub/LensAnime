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
  .bar { width:0%; height: 100px; } .percent {position:absolute; display:inline-block; left:50%; color: #040608; background: none;}
  .like-btn{background: none;border: none;}.like-btn:focus {outline: none;}</style>
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
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">{{$anime->title}}</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div>
        @if(Session::get('success'))
          <div class="alert alert-success text-center">
            {{Session::get('success')}}
          </div>
        @endif
        @if(Session::get('fail'))
          <div class="alert alert-danger text-center">
            {{Session::get('fail')}}
          </div>
        @endif
        @if(Session::get('fail-arr'))
          <div class="input-field">
            @foreach(Session::get('fail-arr') as $key => $err)
            <p class="alert alert-danger text-center">{{$key . ': ' . $err[0]}}</p>
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
                    <div class="w-75 d-flex justify-content-between align-content-center m-auto">
                      <span class="text-bold text-purple">Completed :</span><span class="text-bold">{{$anime->completed}}</span>
                    </div>
                    <div class="w-75 d-flex justify-content-between align-content-center mt-3 mr-auto ml-auto">
                      <span class="text-bold text-purple">Year of release :</span><span>{{$anime->year_of_release ? ($anime->year_of_release) : ("?")}}</span>
                    </div>
                    <div class="w-75 d-flex justify-content-between align-content-center m-auto">
                      <span class="text-bold text-purple">Age classification :</span><span>{{$anime->age_class}}</span>
                    </div>
                    <div class="w-75 d-flex justify-content-between align-content-center m-auto">
                      <span class="text-bold text-purple">Studio :</span><span>{{$anime->studio ? ($anime->studio) : ("?")}}</span>
                    </div>
                  </div>
                  <div class="row justify-content-center mb-3 align-content-center">
                    @foreach(explode(", ", $anime->categories) as $cat)
                      <div class="category">
                        {{$cat}}
                      </div>
                    @endforeach
                  </div>
                  <div class="mb-3 d-flex w-100 justify-content-around align-content-center">
                    <form action="{{route('anime.like.create', [$anime->id, 'type' => 'like'])}}" method="POST">
                      @csrf
                      <button type="submit" class="like-btn"><i class="@if(\App\Models\Like::where(['anime_id' => $anime->id, 'type' => 'like', 'author' => Auth::id()])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i>Like({{count(\App\Models\Like::where(['anime_id' => $anime->id, 'type' => 'like'])->get())}})</button>
                    </form>
                    <form action="{{route('anime.like.create', [$anime->id, 'type' => 'dislike'])}}" method="POST">
                      @csrf
                      <button type="submit" class="like-btn"><i class="@if(\App\Models\Like::where(['anime_id' => $anime->id, 'type' => 'dislike', 'author' => Auth::id()])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i>Dislike({{count(\App\Models\Like::where(['anime_id' => $anime->id, 'type' => 'dislike'])->get())}})</button>
                    </form>
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
                  <li class="nav-item"><a class="nav-link" href="#comments" data-toggle="tab">Comments({{count($comments)}})</a></li>            
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="episodes">
                  <div class="row flex-row justify-content-start">
                    @foreach($episodes as $ep)
                    <a href="{{route('episode.details', $ep->id)}}" class="mr-2">
                      <div class="card" style="width: 8rem;">
                        <img class="card-img-top" src="{{$anime->image}}" alt="Card image cap">
                        <div class="card-body">
                          <p class="text-center text-bold">Episode - {{$ep->number}}</p>
                        </div>
                      </div>
                    </a>
                    @endforeach
                  </div>
                </div>
                <div class="tab-pane" id="comments">
                <div class="form-group">
                  <form action="{{route('anime.comments.create', $anime->id)}}" method="POST" class="d-flex align-content-center">
                    @csrf
                    <input type="text" id="content" name="content" class="form-control" maxlength="40" placeholder="type a comment...">
                    <button class="btn btn-default"><i class="fas fa-arrow-right"></i></button>
                  </form>
                </div>
                  @foreach($comments as $comment)
                  <div class="card card-body">
                    <div>
                      <img class="img-circle img-sm img-bordered-sm" src="{{\App\Models\User::find($comment->author)->profile_photo}}" alt="user image">  
                      <a class="ml-1">{{\App\Models\User::find($comment->author)->username}}</a>
                      <span class="text-muted text-sm text-right">{{$comment->created_at}}</span>
                        <span class="float-right btn-tool  @if($comment->status === 'active') text-success @else text-danger @endif">{{$comment->status}}</span>
                    </div>
                    <div class="mt-2 ml-2">
                      <span>{{$comment->content}}</span>
                    </div>
                    <div class="input-group">
                    <form action="{{route('comment.like.create', [$comment->id, 'type' => 'like'])}}" method="POST">
                      @csrf
                        <button type="submit" class="like-btn"><i class="@if(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'like', 'author' => Auth::id()])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i>Like({{count(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'like'])->get())}})</button>
                      </form>
                      <form action="{{route('comment.like.create', [$comment->id, 'type' => 'dislike'])}}" method="POST">
                      @csrf
                        <button type="submit" class="like-btn"><i class="@if(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'dislike', 'author' => Auth::id()])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i>Dislike({{count(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'dislike'])->get())}})</button>
                      </form>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="link-black mr-3" href="" data-toggle="modal" data-target="#modal-edit-{{$comment->id}}">Edit</a>
                        <a class="link-black mr-3" href="" data-toggle="modal" data-target="#modal-deleteComment-{{$comment->id}}">Remove</a>
                        <a class="link-black" data-toggle="collapse" href="#replies-{{$comment->id}}" role="button" aria-expanded="false" aria-controls="replies-{{$comment->id}}">reply({{count(\App\Models\Comment::where('comment_id', $comment->id)->get())}})</a>
                        <br>
                    </div>
                    @include('admin.layout.replies' ,['comment' => $comment])
                  </div>
                  <div class="modal fade" id="modal-deleteComment-{{$comment->id}}">
                    <div class="modal-dialog">
                      <div class="modal-content bg-danger">
                        <div class="modal-header">
                          <h4 class="modal-title">Confirmation</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>You are about to delete a comment. Are you sure? </p>
                        </div>
                        <form action="{{route('comments.delete', $comment->id)}}" method="POST">
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
                  <div class="modal fade" id="modal-edit-{{$comment->id}}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Comment</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{route('comments.update', $comment->id)}}" method="POST">
                          @csrf
                          @method('PATCH')
                          <div class="modal-body">
                              <div class="form-group">
                                  <label for="status">Comment's status</label>
                                  <select id="status" name="status" class="form-control custom-select">
                                      <option selected disabled>{{$comment->status}}</option>
                                      <option>active</option>
                                      <option>inactive</option>
                                  </select>
                                  @if($comment->author === Auth::id())
                                  <label for="status" class="mt-2">Content</label>
                                  <input type="text" id="content" name="content" class="form-control" maxlength="40" placeholder="type a comment..." value="{{$comment->content}}">
                                  @endif
                              </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  @endforeach
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
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add episode</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ep-form" action="{{route('episode.create',  $anime->id)}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                    <label for="number">Episode number</label>
                    <input type="number" id="number" name="number" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description <span class="small">(optional)</span></label>
                    <textarea type="text" id="description" name="description" class="form-control" maxlength="500"></textarea>
                </div>
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="#byLink" data-toggle="tab">Import by Embed src link</a></li>            
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane server_links" id="byLink">
                    <div class="d-flex">
                      <input type="text" id="server_name" name="server_name[]" class="form-control" placeholder="server name" style="width: 35%;">
                      <input type="text" id="src" name="src[]" class="form-control" placeholder="Embed code src link">
                      <select id="purpose" name="purpose[]" class="form-control custom-select"style="width: 20%;">
                        <option selected>watch</option>
                        <option>download</option>
                      </select>
                    </div>
                  </div>
                  <div type="button" id="add_ep_server" class="btn btn-success mt-2">Add server</div>
                </div>
              </div>
              <!-- <div class="progress mt-2">
                <div class="bar bg-blue"></div>
                <div class="percent text-bold">0%</div>
              </div> -->
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
    $('#add_ep_server').click(function(){
      var row = '<div class="d-flex added_server">'+
                      '<input type="text" id="server_name" name="server_name[]" class="form-control" placeholder="server name" style="width: 35%;">'+
                      '<input type="text" id="src" name="src[]" class="form-control" placeholder="Embed code src link">'+
                     ' <select id="purpose" name="purpose[]" class="form-control custom-select">'+
                       ' <option selected>watch</option>'+
                        '<option>download</option>'+
                      '</select>'+
                      '<div class="btn btn-danger" id="remove_server" onClick="$(this).parent().remove();"><i class="fas fa-trash"><i/></div>'+
                      '</div>'
      $('.server_links').append(row)
    })
});
</script>
</body>
</html>
