@extends('layouts.admin.master')

@section('title', 'Edit Category')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Category</h3>

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

    <form action="{{ route('admin.productManagement.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $category->name) }}" required>
        </div>

        {{-- Parent Category --}}
        <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">— Main Category —</option>
        
                @foreach($categories as $parent)
                    <option value="{{ $parent->id }}"
                        {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
        
                    @foreach($parent->children as $child)
                        <option value="{{ $child->id }}"
                            {{ $category->parent_id == $child->id ? 'selected' : '' }}>
                            └─ {{ $child->name }}
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>


        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description">{{ old('description', $category->description) }}</textarea>
        </div>

        {{-- Save and Back Buttons --}}
        <div class=" mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.productManagement.categories.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
