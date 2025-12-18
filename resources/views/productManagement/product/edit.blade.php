@extends('layouts.admin.master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Product</h3>

    {{-- Display Validation Errors --}}
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

    <form method="POST" action="{{ route('admin.productManagement.product.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories->where('parent_id', null) as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @foreach($cat->children as $child)
                        <option value="{{ $child->id }}" {{ $child->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                            └─ {{ $child->name }}
                        </option>
                        @foreach($child->children as $subChild)
                            <option value="{{ $subChild->id }}" {{ $subChild->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                  └─ {{ $subChild->name }}
                            </option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>

        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>

        {{-- Current Image --}}
        @if($product->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="150">
            </div>
        @endif

        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">Change Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.productManagement.product.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
