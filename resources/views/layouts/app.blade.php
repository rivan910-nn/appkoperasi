
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'KoperasiKu') | Sistem Informasi Koperasi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="koperasi-body">

    {{-- NAVBAR ATAS --}}
    <nav class="navbar navbar-dark top-navbar shadow-sm">
        <div class="container-fluid px-3 px-lg-4">

            <button
                class="btn sidebar-toggle me-2"
                type="button"
                id="sidebarToggle"
                aria-controls="sidebarMenu"
                aria-expanded="true"
                aria-label="Tutup menu navigasi"
                title="Buka/tutup menu navigasi">
                <span aria-hidden="true">☰</span>
            </button>

            <a
                class="navbar-brand d-flex align-items-center gap-2 fw-bold mb-0"
                href="{{ \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : route('anggota.index') }}">

                <span class="brand-icon">K</span>

                <span>
                    KoperasiKu
                    <small class="d-block fw-normal brand-subtitle">
                        Sistem Informasi Koperasi
                    </small>
                </span>
            </a>

            <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">

                @auth
                    <div class="d-flex align-items-center gap-2 user-profile">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="text-white user-details">
                            <div class="fw-semibold user-name">
                                {{ auth()->user()->name }}
                            </div>

                            <small class="user-role">
                                {{ ucfirst(auth()->user()->role) }}
                            </small>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf

                        <button type="submit" class="btn btn-logout">
                            <span aria-hidden="true">↪</span>
                            <span class="logout-label">Logout</span>
                        </button>
                    </form>
                @endauth

            </div>
        </div>
    </nav>

    <div class="app-shell">

        {{-- SIDEBAR KIRI --}}
        <aside class="sidebar" id="sidebarMenu">

            <div class="sidebar-heading">MENU UTAMA</div>

            {{-- DASHBOARD --}}
            @if(\Illuminate\Support\Facades\Route::has('dashboard'))
                <a
                    href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <span class="sidebar-icon">▦</span>
                    <span>Dashboard</span>
                </a>
            @else
                <a
                    href="{{ url('/dashboard') }}"
                    class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">

                    <span class="sidebar-icon">▦</span>
                    <span>Dashboard</span>
                </a>
            @endif

            {{-- DATA ANGGOTA --}}
            <a
                href="{{ route('anggota.index') }}"
                class="sidebar-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}">

                <span class="sidebar-icon">♙</span>
                <span>Data Anggota</span>
            </a>

            {{-- SIMPANAN --}}
            <a
                href="{{ route('simpanan.index') }}"
                class="sidebar-link {{ request()->routeIs('simpanan.*') ? 'active' : '' }}">

                <span class="sidebar-icon">▤</span>
                <span>Simpanan</span>
            </a>

            {{-- PINJAMAN --}}
            @if(\Illuminate\Support\Facades\Route::has('pinjaman.index'))
                <a
                    href="{{ route('pinjaman.index') }}"
                    class="sidebar-link {{ request()->routeIs('pinjaman.*') ? 'active' : '' }}">

                    <span class="sidebar-icon">💰</span>
                    <span>Pinjaman</span>
                </a>
            @else
                <a
                    href="{{ url('/pinjaman') }}"
                    class="sidebar-link {{ request()->is('pinjaman*') ? 'active' : '' }}">

                    <span class="sidebar-icon">💰</span>
                    <span>Pinjaman</span>
                </a>
            @endif

            {{-- ANGSURAN --}}
            @if(\Illuminate\Support\Facades\Route::has('angsuran.index'))
                <a
                    href="{{ route('angsuran.index') }}"
                    class="sidebar-link {{ request()->routeIs('angsuran.*') ? 'active' : '' }}">

                    <span class="sidebar-icon">▣</span>
                    <span>Angsuran</span>
                </a>
            @else
                <a
                    href="{{ url('/angsuran') }}"
                    class="sidebar-link {{ request()->is('angsuran*') ? 'active' : '' }}">

                    <span class="sidebar-icon">▣</span>
                    <span>Angsuran</span>
                </a>
            @endif

            {{-- MANAJEMEN USER --}}
            @auth
                @if(auth()->user()->role === 'admin')
                    <a
                        href="{{ route('users.index') }}"
                        class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">

                        <span class="sidebar-icon">⚙</span>
                        <span>Manajemen User</span>
                    </a>
                @endif
            @endauth

        </aside>

        {{-- KONTEN HALAMAN --}}
        <div class="main-area">

            <main class="main-content">
                <div class="container-fluid px-3 px-lg-4">

                    @hasSection('page-title')
                        <div class="page-heading mb-4">
                            <h4 class="fw-bold mb-1">
                                @yield('page-title')
                            </h4>

                            @hasSection('page-description')
                                <p class="text-muted mb-0 mt-2">
                                    @yield('page-description')
                                </p>
                            @endif
                        </div>
                    @endif

                    {{-- NOTIFIKASI BERHASIL --}}
                    @if(session('success'))
                        <div
                            class="alert alert-success alert-dismissible fade show shadow-sm"
                            role="alert">

                            <strong>Berhasil!</strong>
                            {{ session('success') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Tutup">
                            </button>
                        </div>
                    @endif

                    {{-- NOTIFIKASI ERROR --}}
                    @if(session('error'))
                        <div
                            class="alert alert-danger alert-dismissible fade show shadow-sm"
                            role="alert">

                            <strong>Perhatian!</strong>
                            {{ session('error') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Tutup">
                            </button>
                        </div>
                    @endif

                    {{-- ISI HALAMAN --}}
                    @yield('content')

                </div>
            </main>

            {{-- FOOTER --}}
            <footer class="footer-custom">
                <div
                    class="container-fluid px-3 px-lg-4 d-flex flex-column flex-md-row
                           justify-content-between align-items-center gap-2 py-3">

                    <div class="text-muted small">
                        &copy; {{ date('Y') }}
                        <strong class="text-primary">KoperasiKu</strong>.
                        Sistem Informasi Koperasi.
                    </div>

                    <div class="text-muted small">
                        Dikelola dengan aman dan efisien.
                    </div>
                </div>
            </footer>

        </div>
    </div>

    {{-- CSS --}}
    <style>
        :root {
            --koperasi-blue: #17478d;
            --koperasi-blue-dark: #123467;
            --koperasi-accent: #2563eb;
            --sidebar-width: 250px;
        }

        * {
            box-sizing: border-box;
        }

        body.koperasi-body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #263449;
            background: #f4f7fb;
        }

        /* NAVBAR */
        .top-navbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            min-height: 76px;
            background: linear-gradient(135deg, #123b75, #2563eb);
        }

        .sidebar-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            color: #fff;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 8px;
            font-size: 22px;
            line-height: 1;
        }

        .sidebar-toggle:hover,
        .sidebar-toggle:focus {
            color: #fff;
            background: rgba(255,255,255,.15);
            border-color: rgba(255,255,255,.75);
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            color: #fff;
            background: rgba(255,255,255,.17);
            border: 1px solid rgba(255,255,255,.2);
            font-size: 23px;
            font-weight: 800;
        }

        .brand-subtitle {
            font-size: 10px;
            opacity: .82;
            letter-spacing: .4px;
        }

        /* PROFIL USER */
        .user-profile {
            padding-left: 18px;
            border-left: 1px solid rgba(255,255,255,.25);
        }

        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 50%;
            color: #1d4ed8;
            background: #fff;
            font-size: 17px;
            font-weight: 700;
        }

        .user-name {
            max-width: 170px;
            overflow-wrap: anywhere;
            font-size: 13px;
        }

        .user-role {
            font-size: 11px;
            opacity: .82;
        }

        /* TOMBOL LOGOUT */
        .btn-logout {
            padding: 8px 14px;
            border: 1px solid rgba(255,255,255,.65);
            border-radius: 8px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .btn-logout:hover {
            color: #1d4ed8;
            background: #fff;
            border-color: #fff;
        }

        /* LAYOUT */
        .app-shell {
            display: flex;
            align-items: stretch;
            min-height: calc(100vh - 76px);
        }

        .sidebar {
            width: var(--sidebar-width);
            flex: 0 0 var(--sidebar-width);
            padding: 24px 14px;
            color: #fff;
            background: linear-gradient(
                180deg,
                var(--koperasi-blue),
                var(--koperasi-blue-dark)
            );
        }

        /* SIDEBAR COLLAPSE */
        .app-shell.sidebar-collapsed .sidebar {
            width: 0;
            flex-basis: 0;
            padding-left: 0;
            padding-right: 0;
            overflow: hidden;
            border: 0;
        }

        .sidebar,
        .main-area {
            transition: width .22s ease, flex-basis .22s ease;
        }

        .sidebar-heading {
            margin: 0 12px 14px;
            color: rgba(255,255,255,.65);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* MENU SIDEBAR */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 7px;
            padding: 12px 13px;
            border-radius: 9px;
            color: rgba(255,255,255,.86);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background .2s ease, color .2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: rgba(255,255,255,.17);
        }

        .sidebar-link.active {
            box-shadow: inset 3px 0 0 #fff;
        }

        .sidebar-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            flex-shrink: 0;
            font-size: 18px;
            line-height: 1;
        }

        /* KONTEN UTAMA */
        .main-area {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            min-width: 0;
        }

        .main-content {
            flex: 1 0 auto;
            padding: 32px 0;
        }

        .page-heading {
            padding-left: 15px;
            border-left: 4px solid #2563eb;
        }

        /* FOOTER */
        .footer-custom {
            margin-top: auto;
            border-top: 1px solid #e5eaf1;
            background: #fff;
        }

        /* TABLET DAN HP */
        @media (max-width: 767.98px) {
            .top-navbar {
                min-height: 68px;
            }

            .brand-icon {
                width: 38px;
                height: 38px;
            }

            .brand-subtitle {
                font-size: 9px;
            }

            .user-profile {
                padding-left: 10px;
            }

            .user-avatar {
                width: 34px;
                height: 34px;
            }

            .user-name {
                max-width: 90px;
                font-size: 12px;
            }

            .user-role {
                font-size: 10px;
            }

            .btn-logout {
                padding: 7px 9px;
                font-size: 12px;
            }

            .app-shell {
                min-height: calc(100vh - 68px);
            }

            .sidebar {
                width: 190px;
                flex-basis: 190px;
                padding: 20px 9px;
            }

            .sidebar-link {
                gap: 8px;
                padding: 11px 9px;
                font-size: 13px;
            }

            .main-content {
                padding: 24px 0;
            }
        }

        /* HP KECIL */
        @media (max-width: 480px) {
            .brand-subtitle {
                display: none !important;
            }

            .brand-icon {
                width: 34px;
                height: 34px;
                font-size: 19px;
            }

            .navbar-brand {
                gap: 7px !important;
                font-size: 15px;
            }

            .user-profile {
                gap: 6px !important;
            }

            .user-avatar {
                width: 30px;
                height: 30px;
            }

            .user-name {
                max-width: 70px;
                font-size: 11px;
            }

            .logout-label {
                display: none;
            }

            .sidebar {
                width: 62px;
                flex-basis: 62px;
                padding: 16px 6px;
            }

            .sidebar-heading {
                display: none;
            }

            .sidebar-link {
                justify-content: center;
                padding: 13px 5px;
            }

            .sidebar-link span:last-child {
                display: none;
            }

            .sidebar-icon {
                font-size: 20px;
            }

            .sidebar-link.active {
                box-shadow: inset 0 -3px 0 #fff;
            }
        }
    </style>

    {{-- JAVASCRIPT SIDEBAR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const shell = document.querySelector('.app-shell');
            const sidebar = document.getElementById('sidebarMenu');

            if (!toggle || !shell || !sidebar) return;

            toggle.addEventListener('click', function () {
                const isCollapsed =
                    shell.classList.toggle('sidebar-collapsed');

                toggle.setAttribute(
                    'aria-expanded',
                    String(!isCollapsed)
                );

                toggle.setAttribute(
                    'aria-label',
                    isCollapsed
                        ? 'Buka menu navigasi'
                        : 'Tutup menu navigasi'
                );

                toggle.setAttribute(
                    'title',
                    isCollapsed
                        ? 'Buka menu navigasi'
                        : 'Tutup menu navigasi'
                );
            });
        });
    </script>

</body>
</html>
