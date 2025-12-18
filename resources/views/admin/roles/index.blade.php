@extends('layouts.admin.master')

@section('title', 'Roles Management')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Role Management</h2>
        </div>
        <div class="pull-right">
            @can('role-create')
            <a class="btn btn-success mb-2" href="{{ route('admin.roles.create') }}">
                <i class="fa fa-plus"></i> Create New Role
            </a>
            @endcan
        </div>
    </div>
</div>

{{-- Success message --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@endif

<table class="table table-bordered roles-table">
    <tr>
        <th width="100px">No</th>
        <th>Name</th>
        <th width="280px">Action</th>
    </tr>
    @php
        $i = ($roles->currentPage() - 1) * $roles->perPage();
    @endphp
    @foreach ($roles as $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('admin.roles.show', $role->id) }}">
                <i class="fa-solid fa-list"></i> Show
            </a>
            @can('role-edit')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.edit', $role->id) }}">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            @endcan
            @can('role-delete')
            <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </form>
            @endcan
        </td>
    </tr>
    @endforeach
</table>

{{-- Pagination --}}
<div class="d-flex justify-content-center">
    {!! $roles->links('pagination::bootstrap-5') !!}
</div>

@endsection
