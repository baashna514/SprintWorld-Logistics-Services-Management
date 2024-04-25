<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}"> <img alt="image" src="{{ asset('assets/img/logo.jpg') }}" class="header-logo" />
        </a>
    </div>
    <ul class="sidebar-menu">
        @if(!\Illuminate\Support\Facades\Auth::user()->hasRole('Accountant'))
            <li class="dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
        @endif
        <li><a class="nav-link" href="{{ route('orders', ['status' => 'open']) }}"><i data-feather="shopping-cart"></i><span>LHR</span></a></li>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <li><a class="nav-link" href="{{ route('users') }}"><i data-feather="users"></i><span>Users</span></a></li>
            <li><a class="nav-link" href="{{ route('roles') }}"><i data-feather="user"></i><span>Roles</span></a></li>
        @endif
    </ul>
</aside>
