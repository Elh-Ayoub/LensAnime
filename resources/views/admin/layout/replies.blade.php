<div class="collapse" id="replies-{{$comment->id}}">
    <form class="input-group mb-2" action="{{route('reply.comments.create', $comment->id)}}" method="POST">
    @csrf
    <input class="form-control form-control-sm" name="content" type="text" placeholder="Type a reply..." require>
    <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-arrow-right"></i></button>
    </form>
    @foreach(\App\Models\Comment::where('comment_id', $comment->id)->get() as $reply)
    <div class="card card-body">
    <div class="">
        <img class="img-circle img-sm img-bordered-sm" src="{{\App\Models\User::find($reply->author)->profile_photo}}" alt="user image">  
        <a class="ml-1" >{{\App\Models\User::find($reply->author)->username}}</a>
        <span class="text-muted text-sm text-right">{{$reply->created_at}}</span>
        @if($reply->status == "active")
        <span class="float-right btn-tool text-success">{{$reply->status}}</span>
        @else
        <span class="float-right btn-tool text-danger">{{$reply->status}}</span>
        @endif
    </div>
    <div class="mt-1 ml-2">
        <span>{{$reply->content}}</span>
    </div>
    <div class="input-group">
        <form action="{{route('comment.like.create', [$reply->id, 'type' => 'like'])}}" method="POST">
        @csrf
        <button type="submit" class="like-btn"><i class="@if(\App\Models\Like::where(['comment_id' => $reply->id, 'type' => 'like', 'author' => Auth::id()])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i>Like({{count(\App\Models\Like::where(['comment_id' => $reply->id, 'type' => 'like'])->get())}})</button>
        </form>
        <form action="{{route('comment.like.create', [$reply->id, 'type' => 'dislike'])}}" method="POST">
        @csrf
        <button type="submit" class="like-btn"><i class="@if(\App\Models\Like::where(['comment_id' => $reply->id, 'type' => 'dislike', 'author' => Auth::id()])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i>Dislike({{count(\App\Models\Like::where(['comment_id' => $reply->id, 'type' => 'dislike'])->get())}})</button>
        </form>
    </div>
    <div class="d-flex justify-content-end">
        <a class="link-black mr-3" href="" data-toggle="modal" data-target="#modal-editreply-{{$reply->id}}">Edit</a>
        <a class="link-black mr-3" href="" data-toggle="modal" data-target="#modal-deletereply-{{$reply->id}}">Remove</a>
        <br>
    </div>
    </div>
    <div class="modal fade" id="modal-deletereply-{{$reply->id}}">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
        <div class="modal-header">
            <h4 class="modal-title">Confirmation</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>You are about to delete a reply to comment. Are you sure? </p>
        </div>
        <form action="{{route('comments.delete', $reply->id)}}" method="POST">
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
    <div class="modal fade" id="modal-editreply-{{$reply->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Update reply</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('comments.update', $reply->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label for="status">Comment's status</label>
                    <select id="status" name="status" class="form-control custom-select">
                        <option selected disabled>{{$reply->status}}</option>
                        <option>active</option>
                        <option>inactive</option>
                    </select>
                    @if($reply->author === Auth::id())
                    <label for="status" class="mt-2">Content</label>
                    <input type="text" id="content" name="content" class="form-control" maxlength="40" placeholder="type a comment..." value="{{$reply->content}}">
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