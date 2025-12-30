@extends('vendor.layouts.vendor')

@section('title', 'Products Management')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Product Lists</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('vendor.productManagement.product.create') }}">
                <i class="fa fa-plus"></i> Add New Product
            </a>
        </div>
    </div>
</div>

<!-- {{-- ✅ Success Message --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
        {{ $message }}
    </div>
@endif -->

<table class="table table-bordered table-striped align-middle mt-3">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th> 
            <th>Price (₹)</th>
            <th>Stock</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @forelse($products as $p)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @if($p->image)
                        <img src="{{ asset('uploads/products/' . $p->image) }}" alt="{{ $p->name }}" width="50" height="50">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $p->name }}</td>
                <td>
                    @if($p->category)
                        @php
                            $category = $p->category;
                            $path = [];
                            while ($category) {
                                array_unshift($path, $category->name); // prepend to build full path
                                $category = $category->parent;
                            }
                        @endphp
                        {{ implode(' → ', $path) }}
                    @else
                        N/A
                    @endif
                </td>


                <td>{{ $p->description }}</td> 
                <td>{{ $p->price }}</td>
                <td>{{ $p->stock }}</td>

                

                {{-- Actions --}}
                <td>
                    <a href="{{ route('vendor.productManagement.product.edit', $p->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-edit"></i> Edit
                    </a>

                    <form method="POST" action="{{ route('vendor.productManagement.product.destroy', $p->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this product?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No Products Found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Optional: Pagination (if using paginate() instead of get()) --}}
@if(method_exists($products, 'links'))
    <div class="d-flex justify-content-center mt-3">
        {!! $products->links('pagination::bootstrap-5') !!}
    </div>
@endif
@endsection
