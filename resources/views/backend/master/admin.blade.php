<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style88f9.css') }}?v1.1.3">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/interior-admin.css') }}">
</head>
<body class="nk-body interior-admin-page">
    <div class="ia-shell">
        <aside class="ia-sidebar">
            <a class="ia-brand" href="{{ route('admin.dashboard') }}">
                <span class="ia-brand-mark">IS</span>
                <span><strong>Interior Studio</strong><small>Admin Panel</small></span>
            </a>
            <nav class="ia-menu">
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><em class="icon ni ni-dashboard"></em>Dashboard</a>
                <a class="{{ request()->routeIs('admin.banners') ? 'active' : '' }}" href="{{ route('admin.banners') }}"><em class="icon ni ni-img"></em>Banner Management</a>
                <a class="{{ request()->routeIs('admin.testimonials') ? 'active' : '' }}" href="{{ route('admin.testimonials') }}"><em class="icon ni ni-chat-circle"></em>Testimonials</a>
                <a class="{{ request()->routeIs('admin.services') ? 'active' : '' }}" href="{{ route('admin.services') }}"><em class="icon ni ni-setting"></em>Services</a>
                <a class="{{ request()->routeIs('admin.projects') ? 'active' : '' }}" href="{{ route('admin.projects') }}"><em class="icon ni ni-building"></em>Projects</a>
                <a class="{{ request()->routeIs('admin.gallery') ? 'active' : '' }}" href="{{ route('admin.gallery') }}"><em class="icon ni ni-grid-alt"></em>Gallery</a>
                <a class="{{ request()->routeIs('admin.blogs') ? 'active' : '' }}" href="{{ route('admin.blogs') }}"><em class="icon ni ni-file-text"></em>Blogs</a>
                <a class="{{ request()->routeIs('admin.inquiries') ? 'active' : '' }}" href="{{ route('admin.inquiries') }}"><em class="icon ni ni-question"></em>Inquiry</a>
                <a class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}"><em class="icon ni ni-setting-alt"></em>Settings</a>
                <a class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}"><em class="icon ni ni-user"></em>Profile</a>
                <form action="{{ route('admin.logout') }}" method="post" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-sm ia-sidebar-logout w-100">
                        <em class="icon ni ni-signout"></em>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <main class="ia-main">
            <header class="ia-topbar">
                <button class="ia-menu-toggle" type="button" aria-label="Toggle menu"><em class="icon ni ni-menu"></em></button>
                <div>
                    <p class="ia-kicker">Premium interior website CMS</p>
                    <h1>@yield('page_heading', 'Dashboard')</h1>
                </div>
                <div class="ia-profile">
                    <span>{{ auth()->user()->name ?? auth()->user()->username ?? 'Studio Admin' }}</span>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script src="{{ asset('backend/assets/js/bundle88f9.js') }}?v1.1.3"></script>
    <script src="{{ asset('backend/assets/js/data-tables/data-tables.js') }}?v1.1.3"></script>
    <script src="{{ asset('backend/assets/js/scripts88f9.js') }}?v1.1.3"></script>
    <script>
        document.addEventListener('change', function (event) {
            const master = event.target.closest('.ia-select-all');
            if (master) {
                const table = master.closest('form, .card, .table-responsive') || document;
                table.querySelectorAll('.ia-row-check').forEach((checkbox) => {
                    checkbox.checked = master.checked;
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
