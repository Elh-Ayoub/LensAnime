<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin.dashboard')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @if(!Auth::user())
      <li class="nav-item">
        <a class="nav-link" href="{{route('login')}}">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('register')}}">Register</a>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.auth.logout')}}">Log out</a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
</nav>
