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
    <aside class="bg-white border-end p-4" style="width: 250px;">
        <h4 class="fw-bold mb-4">Admin</h4>
        <ul class="nav nav-pills flex-column gap-2">
            <li class="nav-item"><a class="nav-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link{{ request()->routeIs('admin.products.*') ? ' active' : '' }}" href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="nav-item"><a class="nav-link{{ request()->routeIs('admin.categories.*') ? ' active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a></li>
            <li class="nav-item"><a class="nav-link{{ request()->routeIs('admin.contacts.*') ? ' active' : '' }}" href="{{ route('admin.contacts.index') }}">Contact Messages</a></li>
            <li class="nav-item"><a class="nav-link{{ request()->routeIs('admin.orders.*') ? ' active' : '' }}" href="{{ route('admin.orders.index') }}">Orders</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">View Shop</a></li>
        </ul>
    </aside>

    <div class="flex-fill">
        <header class="bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-0">@yield('page-heading', 'Admin Panel')</h2>
            </div>
        </header>

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
    });
</script>
</body>
</html>
