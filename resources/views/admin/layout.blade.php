<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Saree Bazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="d-flex min-vh-100 bg-light">
    <aside id="adminSidebar" class="admin-sidebar bg-white border-end p-4">
        <h4 class="fw-bold mb-4">Admin</h4>
        @php
            $u = auth()->user();
            $userMgmtActive = request()->routeIs('admin.users.*')
                           || request()->routeIs('admin.roles.*')
                           || request()->routeIs('admin.permissions.*');
        @endphp
        <ul class="nav nav-pills flex-column gap-2">

            @if($u->hasPermission('dashboard.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}"
                   href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            @endif

            @if($u->hasPermission('products.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.products.*') ? ' active' : '' }}"
                   href="{{ route('admin.products.index') }}">Products</a>
            </li>
            @endif

            @if($u->hasPermission('categories.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.categories.*') ? ' active' : '' }}"
                   href="{{ route('admin.categories.index') }}">Categories</a>
            </li>
            @endif

            @if($u->hasPermission('sliders.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.sliders.*') ? ' active' : '' }}"
                   href="{{ route('admin.sliders.index') }}">Slider</a>
            </li>
            @endif

            @if($u->hasPermission('orders.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.orders.*') ? ' active' : '' }}"
                   href="{{ route('admin.orders.index') }}">Orders</a>
            </li>
            @endif

            @if($u->hasPermission('contacts.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.contacts.*') ? ' active' : '' }}"
                   href="{{ route('admin.contacts.index') }}">Contacts</a>
            </li>
            @endif

            @if($u->hasPermission('feedback.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.feedbacks.*') ? ' active' : '' }}"
                   href="{{ route('admin.feedbacks.index') }}">Feedback</a>
            </li>
            @endif

            @if($u->hasPermission('company-profile.view'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.company-profiles.*') ? ' active' : '' }}"
                   href="{{ route('admin.company-profiles.index') }}">Company Profile</a>
            </li>
            @endif

            @if($u->hasPermission('pages.edit'))
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.pages.*') ? ' active' : '' }}"
                   href="{{ route('admin.pages.edit') }}">About Page</a>
            </li>
            @endif

            {{-- User Management (show group if user has at least one sub-permission) --}}
            @if($u->hasPermission('users.view') || $u->hasPermission('roles.view') || $u->hasPermission('permissions.view'))
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center{{ $userMgmtActive ? ' active' : '' }}"
                   href="#userMgmtMenu" data-bs-toggle="collapse" role="button"
                   aria-expanded="{{ $userMgmtActive ? 'true' : 'false' }}">
                    <span>User Management</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </a>
                <div class="collapse{{ $userMgmtActive ? ' show' : '' }}" id="userMgmtMenu">
                    <ul class="nav flex-column ms-3 mt-1 gap-1">
                        @if($u->hasPermission('users.view'))
                        <li class="nav-item">
                            <a class="nav-link py-1{{ request()->routeIs('admin.users.*') ? ' active' : '' }}"
                               href="{{ route('admin.users.index') }}">Users</a>
                        </li>
                        @endif
                        @if($u->hasPermission('roles.view'))
                        <li class="nav-item">
                            <a class="nav-link py-1{{ request()->routeIs('admin.roles.*') ? ' active' : '' }}"
                               href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                        @endif
                        @if($u->hasPermission('permissions.view'))
                        <li class="nav-item">
                            <a class="nav-link py-1{{ request()->routeIs('admin.permissions.*') ? ' active' : '' }}"
                               href="{{ route('admin.permissions.index') }}">Permissions</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">View Shop</a></li>
        </ul>
    </aside>

    <div class="flex-fill">
        <header class="bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button id="adminMenuToggle" class="btn btn-outline-secondary d-lg-none p-2 admin-menu-toggle" type="button" aria-label="Toggle menu">
                    <span class="admin-menu-bar"></span>
                    <span class="admin-menu-bar"></span>
                    <span class="admin-menu-bar"></span>
                </button>
                <h2 class="h4 mb-0">@yield('page-heading', 'Admin Panel')</h2>
            </div>
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="adminProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center me-2" style="width:36px; height:36px; font-size:.95rem;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminProfileDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile.password.edit') }}">Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </header>
        <div id="adminSidebarOverlay" class="admin-sidebar-overlay d-lg-none"></div>

        <main class="p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        $('.datatable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'pdf', 'print'],
            order: [[0, 'desc']],
            responsive: true,
            pageLength: 10,
        });

        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('adminMenuToggle');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');

            function closeSidebar() {
                sidebar.classList.remove('show-mobile');
                overlay.classList.remove('show');
            }

            toggle?.addEventListener('click', function () {
                sidebar.classList.toggle('show-mobile');
                overlay.classList.toggle('show');
            });

            overlay?.addEventListener('click', closeSidebar);
        });
    });
</script>
</body>
</html>
