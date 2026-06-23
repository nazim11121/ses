@extends('admin.layout')

@section('title', 'Products')
@section('page-heading', 'Manage Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Products</h3>
    @if(auth()->user()->hasPermission('products.create'))
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
    @endif
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ? $product->category->name : 'Unassigned' }}</td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->active ? 'Active' : 'Inactive' }}</td>
                        <td class="text-end">
                            @if(auth()->user()->hasPermission('products.edit'))
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                            @endif
                            @if(auth()->user()->hasPermission('products.delete'))
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
