@extends('layouts.admin.master')

@section('title', 'Edit Role')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.roles.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

{{-- Display validation errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- Name --}}
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Role Name" class="form-control" value="{{ old('name', $role->name) }}">
            </div>
        </div>

        {{-- Permissions --}}
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Permissions:</strong><br/>
                @foreach($permissions as $permission)
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                            {{ (in_array($permission->id, old('permissions', $rolePermissions))) ? 'checked' : '' }}>
                        {{ $permission->name }}
                    </label><br/>
                @endforeach
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </div>
    </div>
</form>

@endsection
