<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                <span class="badge badge-primary"> {{ Auth::user()->role }}</span>
            </div>
            <div style="align-self: center;text-align: right;flex: 1;">
                <a href="{{ route('profile') }}">
                    <i class="fa-solid fa-pen text-white"></i>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('doctors.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-user-doctor"></i>
                        <p>Liste des médecins</p>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-cart-shopping"></i>
                        <p>
                            Liste des commandes
                            @if (App\Models\Order::InProgress()->count() > 0)
                                <span class="badge badge-danger right">
                                    {{ App\Models\Order::InProgress()->count() }}
                                </span>
                            @endif
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-bars"></i>
                        <p>Gestion des produits</p>
                    </a>
                </li>
            </ul>
        </nav>
        @if (Auth::user()->isSuperAdmin())
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fa-solid fa-users"></i>
                            <p>Gestion des utilisateurs</p>
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-user-pen"></i>
                        <p>Modifier mon profile</p>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="#" onclick="return document.getElementById('logout-form').submit()" class="nav-link">
                        <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                        <p>Se déconnecter</p>
                    </a>
                    <form action="{{ route('logout') }}" id="logout-form" method="post" style="display:none">
                        @csrf
                        <button type="submit"></button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
