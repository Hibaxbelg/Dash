<nav class="main-header navbar navbar-expand navbar-white navbar-light mb-3">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto mb-2">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{ Auth::user()->avatar }}" class="rounded-circle" width="35" height="35">
                {{ Auth::user()->name }}
                <i class="fa-solid fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('profile') }}" class="dropdown-item">
                    <i class="fa-solid fa-user-pen"></i> Mon profil
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" onclick="return document.getElementById('logout-form').submit()"
                    class="dropdown-item">
                    <i class=" fa-solid fa-right-from-bracket"></i> Se Déconnecter
                </a>
                <form action="{{ route('logout') }}" id="logout-form" method="post" style="display:none">
                    @csrf
                    <button type="submit"></button>
                </form>
            </div>
        </li>
    </ul>
</nav>
