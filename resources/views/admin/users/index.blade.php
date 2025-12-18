@extends('layouts.admin.master')

@section('title', 'Users Management')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right">
            @can('user-create')
            <a class="btn btn-success mb-2" href="{{ route('admin.users.create') }}">
                <i class="fa fa-plus"></i> Create New User
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

<table class="table table-bordered users-table">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="280px">Action</th>
    </tr>
    @php
        $i = ($data->currentPage() - 1) * $data->perPage();
    @endphp
    @foreach ($data as $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $role)
                    <label class="badge bg-success">{{ $role }}</label>
                @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('admin.users.show', $user->id) }}">
                <i class="fa-solid fa-list"></i> Show
            </a>
            @can('user-edit')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user->id) }}">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            @endcan
            @can('user-delete')
            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline">
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
    {!! $data->links('pagination::bootstrap-5') !!}
</div>

@endsection
