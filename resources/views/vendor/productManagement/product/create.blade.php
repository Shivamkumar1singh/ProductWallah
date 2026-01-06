@extends('vendor.layouts.vendor')
@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Add Product</h3>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vendor.productManagement.product.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @php
                    // Recursive function to render categories
                    function renderCategories($categories, $prefix = '') {
                        foreach ($categories as $category) {
                            echo '<option value="' . $category->id . '"';
                            if (old('category_id') == $category->id) echo ' selected';
                            echo '>' . $prefix . $category->name . '</option>';
        
                            if ($category->childrenRecursive->count()) {
                                renderCategories($category->childrenRecursive, $prefix . '└─ ');
                            }
                        }
                    }
                @endphp
        
                {{-- Render top-level categories recursively --}}
                @php
                    renderCategories($categories->where('parent_id', null));
                @endphp
            </select>

        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter product description"></textarea>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Enter price" required>
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" placeholder="Enter stock quantity" required>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('vendor.productManagement.product.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
