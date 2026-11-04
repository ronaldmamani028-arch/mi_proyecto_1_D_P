<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Administrador</span>
                    <span class="text-secondary text-small">Sistema de Gestión</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('productos.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('productos.index') }}">
                <span class="menu-title">Productos</span>
                <i class="mdi mdi-cart menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('productos.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('productos.create') }}">
                <span class="menu-title">Registrar Producto</span>
                <i class="mdi mdi-plus-box menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
