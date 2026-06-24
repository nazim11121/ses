<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Saree Bazaar</title>
    {{-- Apply saved theme BEFORE paint to prevent flash --}}
    <script>(function(){var t=localStorage.getItem('ap_theme');if(t==='dark')document.documentElement.setAttribute('data-theme','dark');})();</script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>

@php
    $u = auth()->user();
    $userMgmtActive = request()->routeIs('admin.users.*')
                   || request()->routeIs('admin.roles.*')
                   || request()->routeIs('admin.permissions.*');
    $notifActive = request()->routeIs('admin.notifications.*');
@endphp

{{-- ══════════════ SIDEBAR ══════════════ --}}
<aside id="apSidebar" class="ap-sidebar">

    <div class="ap-brand">
        <div class="ap-brand-icon">S</div>
        <div>
            <div class="ap-brand-name">SareeBazaar</div>
            <div class="ap-brand-sub" data-i18n="Admin Panel">Admin Panel</div>
        </div>
    </div>

    <nav class="ap-nav">

        <div class="ap-nav-section" data-i18n="Main">Main</div>

        @if($u->hasPermission('dashboard.view'))
        <a href="{{ route('admin.dashboard') }}" class="ap-nav-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span>
            <span data-i18n="Dashboard">Dashboard</span>
        </a>
        @endif

        @if($u->hasPermission('orders.view'))
        <a href="{{ route('admin.orders.index') }}" class="ap-nav-link{{ request()->routeIs('admin.orders.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></span>
            <span data-i18n="Orders">Orders</span>
        </a>
        @endif

        @if($u->hasPermission('products.view'))
        <a href="{{ route('admin.products.index') }}" class="ap-nav-link{{ request()->routeIs('admin.products.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></span>
            <span data-i18n="Products">Products</span>
        </a>
        @endif

        @if($u->hasPermission('categories.view'))
        <a href="{{ route('admin.categories.index') }}" class="ap-nav-link{{ request()->routeIs('admin.categories.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></span>
            <span data-i18n="Categories">Categories</span>
        </a>
        @endif

        @if($u->hasPermission('sliders.view'))
        <a href="{{ route('admin.sliders.index') }}" class="ap-nav-link{{ request()->routeIs('admin.sliders.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></span>
            <span data-i18n="Slider">Slider</span>
        </a>
        @endif

        <div class="ap-nav-section" data-i18n="Content">Content</div>

        @if($u->hasPermission('contacts.view'))
        <a href="{{ route('admin.contacts.index') }}" class="ap-nav-link{{ request()->routeIs('admin.contacts.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
            <span data-i18n="Contacts">Contacts</span>
        </a>
        @endif

        @if($u->hasPermission('feedback.view'))
        <a href="{{ route('admin.feedbacks.index') }}" class="ap-nav-link{{ request()->routeIs('admin.feedbacks.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
            <span data-i18n="Feedback">Feedback</span>
        </a>
        @endif

        @if($u->hasPermission('company-profile.view'))
        <a href="{{ route('admin.company-profiles.index') }}" class="ap-nav-link{{ request()->routeIs('admin.company-profiles.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
            <span data-i18n="Company Profile">Company Profile</span>
        </a>
        @endif

        @if($u->hasPermission('pages.edit'))
        <a href="{{ route('admin.pages.edit') }}" class="ap-nav-link{{ request()->routeIs('admin.pages.*') ? ' active' : '' }}">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></span>
            <span data-i18n="About Page">About Page</span>
        </a>
        @endif

        @if($u->hasPermission('users.view') || $u->hasPermission('roles.view') || $u->hasPermission('permissions.view') || $u->hasPermission('notifications.view') || $u->hasPermission('notifications.manage'))
        <div class="ap-nav-section" data-i18n="System">System</div>
        @endif

        @if($u->hasPermission('users.view') || $u->hasPermission('roles.view') || $u->hasPermission('permissions.view'))
        <div class="ap-nav-group{{ $userMgmtActive ? ' open' : '' }}">
            <button class="ap-nav-link ap-nav-group-toggle" type="button" data-target="userMgmtSub">
                <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                <span data-i18n="User Management">User Management</span>
                <svg class="ap-nav-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="ap-nav-sub{{ $userMgmtActive ? ' show' : '' }}" id="userMgmtSub">
                @if($u->hasPermission('users.view'))
                <a href="{{ route('admin.users.index') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.users.*') ? ' active' : '' }}" data-i18n="Users">Users</a>
                @endif
                @if($u->hasPermission('roles.view'))
                <a href="{{ route('admin.roles.index') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.roles.*') ? ' active' : '' }}" data-i18n="Roles">Roles</a>
                @endif
                @if($u->hasPermission('permissions.view'))
                <a href="{{ route('admin.permissions.index') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.permissions.*') ? ' active' : '' }}" data-i18n="Permissions">Permissions</a>
                @endif
            </div>
        </div>
        @endif

        @if($u->hasPermission('notifications.view') || $u->hasPermission('notifications.manage'))
        <div class="ap-nav-group{{ $notifActive ? ' open' : '' }}">
            <button class="ap-nav-link ap-nav-group-toggle" type="button" data-target="notifSub">
                <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></span>
                <span data-i18n="Notifications">Notifications</span>
                <svg class="ap-nav-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="ap-nav-sub{{ $notifActive ? ' show' : '' }}" id="notifSub">
                @if($u->hasPermission('notifications.manage'))
                <a href="{{ route('admin.notifications.settings.index') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.notifications.settings.*') ? ' active' : '' }}" data-i18n="Settings">Settings</a>
                <a href="{{ route('admin.notifications.templates.index') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.notifications.templates.*') ? ' active' : '' }}" data-i18n="Templates">Templates</a>
                @endif
                @if($u->hasPermission('notifications.send') || $u->hasPermission('notifications.manage'))
                <a href="{{ route('admin.notifications.send') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.notifications.send') ? ' active' : '' }}" data-i18n="Send">Send</a>
                @endif
                @if($u->hasPermission('notifications.view') || $u->hasPermission('notifications.manage'))
                <a href="{{ route('admin.notifications.logs') }}" class="ap-nav-sub-link{{ request()->routeIs('admin.notifications.logs') ? ' active' : '' }}" data-i18n="Logs">Logs</a>
                @endif
            </div>
        </div>
        @endif

        <div class="ap-nav-section" data-i18n="Store">Store</div>
        <a href="{{ route('home') }}" target="_blank" class="ap-nav-link">
            <span class="ap-nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg></span>
            <span data-i18n="View Shop">View Shop</span>
            <svg style="margin-left:auto;opacity:.4" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        </a>

    </nav>
</aside>

<div id="apSidebarOverlay" class="ap-sidebar-overlay"></div>

{{-- ══════════════ MAIN ══════════════ --}}
<div class="ap-main" id="apMain">

    {{-- Header --}}
    <header class="ap-header">
        <div class="ap-header-left">
            <button id="apSidebarToggle" class="ap-toggle-btn" type="button" aria-label="Toggle sidebar">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="ap-breadcrumb">
                <span class="ap-breadcrumb-home" data-i18n="Admin">Admin</span>
                <span class="ap-breadcrumb-sep">/</span>
                <span class="ap-breadcrumb-current">@yield('page-heading', 'Dashboard')</span>
            </div>
        </div>

        <div class="ap-header-right">

            {{-- ── Switcher group ── --}}
            <div class="ap-switcher-group">

                {{-- Language toggle --}}
                <button id="apLangToggle" class="ap-lang-btn" title="Switch language" aria-label="Switch language">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    <span id="apLangLabel">EN</span>
                </button>

                {{-- Dark / Light toggle --}}
                <button id="apThemeToggle" class="ap-icon-btn" title="Toggle dark mode" aria-label="Toggle theme">
                    {{-- Moon — shown in light mode --}}
                    <svg class="ap-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    {{-- Sun — shown in dark mode --}}
                    <svg class="ap-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                </button>

            </div>

            @auth
            <div class="dropdown">
                <button class="ap-avatar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="ap-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="ap-avatar-name">{{ auth()->user()->name }}</span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end ap-dropdown">
                    <li>
                        <div class="ap-dropdown-header">
                            <span class="ap-avatar ap-avatar-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <div>
                                <div style="font-weight:600;font-size:.875rem">{{ auth()->user()->name }}</div>
                                <div style="font-size:.75rem;color:#64748b">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item ap-dropdown-item" href="{{ route('admin.profile.edit') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span data-i18n="My Profile">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item ap-dropdown-item" href="{{ route('admin.profile.password.edit') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <span data-i18n="Change Password">Change Password</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit" class="dropdown-item ap-dropdown-item text-danger">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                <span data-i18n="Logout">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </header>

    {{-- Content --}}
    <main class="ap-content">
        @if(session('success'))
        <div class="ap-alert ap-alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="ap-alert ap-alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>
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
        buttons: ['copy','excel','pdf','print'],
        order: [[0,'desc']],
        responsive: true,
        pageLength: 10,
    });
});

(function () {
    /* ── Sidebar toggle ── */
    var sidebar = document.getElementById('apSidebar');
    var overlay = document.getElementById('apSidebarOverlay');
    var toggle  = document.getElementById('apSidebarToggle');

    function openSb()  { sidebar.classList.add('open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
    function closeSb() { sidebar.classList.remove('open'); overlay.classList.remove('show'); document.body.style.overflow=''; }

    if (toggle)  toggle.addEventListener('click', function(){ sidebar.classList.contains('open') ? closeSb() : openSb(); });
    if (overlay) overlay.addEventListener('click', closeSb);

    /* ── Sub-menu toggles ── */
    document.querySelectorAll('.ap-nav-group-toggle').forEach(function(btn){
        btn.addEventListener('click', function(){
            var sub   = document.getElementById(this.dataset.target);
            var group = this.closest('.ap-nav-group');
            if (!sub) return;
            var opening = !sub.classList.contains('show');
            document.querySelectorAll('.ap-nav-sub.show').forEach(function(el){ el.classList.remove('show'); });
            document.querySelectorAll('.ap-nav-group.open').forEach(function(el){ el.classList.remove('open'); });
            if (opening) { sub.classList.add('show'); group.classList.add('open'); }
        });
    });

    /* ══════════════════════════════════════════════════════
       DARK / LIGHT THEME SWITCHER
    ══════════════════════════════════════════════════════ */
    var root        = document.documentElement;
    var themeToggle = document.getElementById('apThemeToggle');

    function setTheme(t) {
        if (t === 'dark') root.setAttribute('data-theme','dark');
        else              root.removeAttribute('data-theme');
        localStorage.setItem('ap_theme', t);
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function(){
            setTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });
    }
    /* Theme already applied in <head> inline script — no flicker */

    /* ══════════════════════════════════════════════════════
       BANGLA / ENGLISH LANGUAGE SWITCHER
    ══════════════════════════════════════════════════════ */
    var LANG = {
        /* Nav sections */
        'Admin Panel':          'অ্যাডমিন প্যানেল',
        'Main':                 'প্রধান',
        'Content':              'কন্টেন্ট',
        'System':               'সিস্টেম',
        'Store':                'স্টোর',
        /* Nav items */
        'Dashboard':            'ড্যাশবোর্ড',
        'Orders':               'অর্ডার',
        'Products':             'পণ্য',
        'Categories':           'বিভাগ',
        'Slider':               'স্লাইডার',
        'Contacts':             'যোগাযোগ',
        'Feedback':             'প্রতিক্রিয়া',
        'Company Profile':      'কোম্পানি প্রোফাইল',
        'About Page':           'সম্পর্কে',
        'User Management':      'ব্যবহারকারী ব্যবস্থাপনা',
        'Users':                'ব্যবহারকারী',
        'Roles':                'ভূমিকা',
        'Permissions':          'অনুমতি',
        'Notifications':        'বিজ্ঞপ্তি',
        'Settings':             'সেটিংস',
        'Templates':            'টেমপ্লেট',
        'Send':                 'পাঠান',
        'Logs':                 'লগ',
        'View Shop':            'দোকান দেখুন',
        /* Header & dropdown */
        'Admin':                'অ্যাডমিন',
        'My Profile':           'আমার প্রোফাইল',
        'Change Password':      'পাসওয়ার্ড পরিবর্তন',
        'Logout':               'লগআউট',
        /* Dashboard */
        'Overview':             'সংক্ষিপ্ত বিবরণ',
        'View Orders':          'অর্ডার দেখুন',
        'Total Orders':         'মোট অর্ডার',
        'Revenue':              'মোট আয়',
        'In catalogue':         'ক্যাটালগে',
        'Active groups':        'সক্রিয় গ্রুপ',
        'Excluding cancelled':  'বাতিল ব্যতীত',
        'pending':              'অপেক্ষমাণ',
        'Recent Orders':        'সাম্প্রতিক অর্ডার',
        'View all':             'সব দেখুন',
        'Quick Actions':        'দ্রুত পদক্ষেপ',
        'Order Status':         'অর্ডারের অবস্থা',
        'Order':                'অর্ডার নং',
        'Customer':             'গ্রাহক',
        'Amount':               'পরিমাণ',
        'Status':               'অবস্থা',
        'Add Product':          'পণ্য যোগ করুন',
        'All Orders':           'সব অর্ডার',
        'Send Notif':           'বিজ্ঞপ্তি পাঠান',
        'Manage Slider':        'স্লাইডার ব্যবস্থাপনা',
        'No orders yet.':       'এখনো কোনো অর্ডার নেই।',
        'View':                 'দেখুন',
        /* Status labels */
        'Pending':              'অপেক্ষমাণ',
        'Processing':           'প্রক্রিয়াধীন',
        'Shipped':              'পাঠানো হয়েছে',
        'Delivered':            'পৌঁছেছে',
        'Cancelled':            'বাতিল',
    };

    var langToggle = document.getElementById('apLangToggle');
    var langLabel  = document.getElementById('apLangLabel');

    function applyLang(lang) {
        localStorage.setItem('ap_lang', lang);
        if (langLabel) {
            langLabel.textContent = lang === 'bn' ? 'বাং' : 'EN';
        }
        if (langToggle) {
            langToggle.classList.toggle('bn-active', lang === 'bn');
        }
        document.querySelectorAll('[data-i18n]').forEach(function(el){
            var key = el.getAttribute('data-i18n');
            el.textContent = (lang === 'bn' && LANG[key]) ? LANG[key] : key;
        });
    }

    if (langToggle) {
        langToggle.addEventListener('click', function(){
            applyLang(localStorage.getItem('ap_lang') === 'bn' ? 'en' : 'bn');
        });
    }

    /* Apply saved language on every page load */
    applyLang(localStorage.getItem('ap_lang') || 'en');

})();
</script>
@yield('scripts')
</body>
</html>
