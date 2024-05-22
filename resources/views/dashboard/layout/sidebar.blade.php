<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-text mx-3">DB {{ auth()->user()->role->nama }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Barang
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'barang') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barang.index') }}">
            <i class="fas fa-fw fa-sign-in-alt"></i>
            <span>Barang Masuk</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    @if (auth()->user()->role->nama == 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Data Logistik
        </div>
        <!-- Stuff Management -->
        @if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'kategori') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kategori.index') }}">
                    <i class="fas fa-fw fa-tag"></i>
                    <span>Data Kategori Barang</span>
                </a>
            </li>
        @endif
        <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'titikantar') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('titikantar.index') }}">
                <i class="fas fa-fw fa-shipping-fast"></i>
                <span>Data Titik Antar</span>
            </a>
        </li>
        <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'armada') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('armada.index') }}">
                <i class="fas fa-fw fa-bus"></i>
                <span>Data Armada</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Pegawai
        </div>
        <!-- User Management -->
        <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'user') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Data User</span>
            </a>
        </li>
        <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'role') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('role.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Role User</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
