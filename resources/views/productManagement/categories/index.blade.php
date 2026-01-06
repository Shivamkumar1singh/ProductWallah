@extends('layouts.admin.master')

@section('title', 'Categories Management')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <h2>Category Lists</h2>

        <a class="btn btn-success mb-2"
           href="{{ route('admin.productManagement.categories.create') }}">
            <i class="fa fa-plus"></i> Add New Category
        </a>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
        {{ $message }}
    </div>
@endif
 

@php
// Recursive function to render categories
function renderCategoryRows($categories, &$counter, $level = 0) {
    foreach ($categories as $index => $category) {
        echo '<tr>';
        echo '<td>'.($counter ++).'</td>';
        echo '<td>';
        echo $level > 0 ? str_repeat('— ', $level).' '.$category->name : '<strong>'.$category->name.'</strong>';
        echo '</td>';
        echo '<td>'.($category->parent->name ?? 'Main Category').'</td>';
        echo '<td>'.$category->description.'</td>';
        echo '<td>
                <a href="'.route("admin.productManagement.categories.edit", $category->id).'" class="btn btn-sm btn-primary">Edit</a>
                <form method="POST" action="'.route("admin.productManagement.categories.destroy", $category->id).'" style="display:inline;">
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
              </td>';
        echo '</tr>';

        if ($category->childrenRecursive->isNotEmpty()) {
            renderCategoryRows($category->childrenRecursive, $counter, $level + 1);
        }
    }
}
@endphp

<table class="table table-bordered table-striped align-middle mt-3">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Parent Category</th>
            <th>Description</th>
            <th width="280px">Action</th>
        </tr>
    </thead>

    <tbody>
        @php
            $counter = 1;
            renderCategoryRows($categories,$counter);
        @endphp
    </tbody>
</table>

{{-- Optional: Pagination (if using paginate() instead of get()) --}}
@if(method_exists($categories, 'links'))
    <div class="d-flex justify-content-center mt-3">
        {!! $categories->links('pagination::bootstrap-5') !!}
    </div>
@endif
@endsection
