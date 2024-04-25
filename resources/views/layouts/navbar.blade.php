<div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
            </a></li>
        <li>
            <span class="nav-link nav-link-lg font-20">Welcome to <b>{{ \Illuminate\Support\Facades\Auth::user()->roles->first()->name }}</b> Dashboard</span>
        </li>
    </ul>
</div>
<ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i data-feather="clock"></i>
        </a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
            <div class="dropdown-header">
                Last Login : <i data-feather="clock"></i>  {{ \Illuminate\Support\Facades\Auth::user()->last_login }}
            </div>
        </div>
    </li>
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('assets/img/users/user-3.png') }}" class="user-img-radious-style">
            <span class="d-sm-none d-lg-inline-block"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right pullDown">
            <div class="dropdown-title">Hello, {{ Auth::user()->name }}!</div>
            <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item has-icon" style="margin-top: -10px;"><i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </div>
    </li>
</ul>
