<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_transparent.png')}}"/>
  <title>Categories - {{env('APP_NAME')}}</title>
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
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Categories</li>
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
          <button class="btn btn-primary ml-2 mb-3" data-toggle="modal" data-target="#modal-create-cat"><i class="fas fa-plus mr-2"></i>Add category</button>
        </div>
        <div class="card card-solid">
          <div class="card-body pb-0">
            <div class="row justify-content-start">
                @foreach($categories as $category)
                  <div class="col-lg-3 col-6 d-flex align-items-stretch flex-column">
                    <div class="small-box categories flex-fill" id="{{str_replace(' ', '-', $category->title)}}">
                      <div class="inner">
                          <h3 class="title">{{$category->title}}</h3>
                          @if($category->description)
                            <p>{{$category->description}}</p>
                          @else
                            <p>No description</p>
                          @endif
                      </div>
                      <div class="icon">
                          <i class="fab fa-{{strtolower($category->title)}}"></i>
                      </div>
                      <a href="#" type="button" class="small-box-footer" data-toggle="modal" data-target="#modal-update-{{$category->id}}">Edit or Delete <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="modal fade" id="modal-update-{{$category->id}}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Category</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{route('categories.update', $category->id)}}" method="POST">
                          @csrf
                          @method('PATCH')
                          <div class="modal-body">
                              <div class="form-group">
                                  <label for="title">Title</label>
                                  <input type="text" name="title" class="form-control" maxlength="100" value="{{$category->title}}">
                              </div>
                              <div class="form-group">
                                  <label for="description">Description</label>
                                  <textarea name="description" class="form-control" maxlength="200">{{$category->description}}</textarea>
                              </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$category->id}}">Delete</button>
                              <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="modal-delete-{{$category->id}}">
                    <div class="modal-dialog">
                      <div class="modal-content bg-danger">
                        <div class="modal-header">
                          <h4 class="modal-title">Confirmation</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{route('categories.delete', $category->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="modal-body">
                              <p>You are about to delete a category. Are you sure?</p>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-outline-light">Delete</button>
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
    </section>
    <div class="modal fade" id="modal-create-cat">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('categories.create')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" maxlength="200"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
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
<script src="{{ asset('js/categories.js') }}"></script>
</body>
</html>
