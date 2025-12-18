@extends('layouts.admin.master')

@section('title', 'Create New Role')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Role</h2>
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

<form method="POST" action="{{ route('admin.roles.store') }}">
    @csrf
    <div class="row">
        {{-- Role Name --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Role Name" class="form-control" value="{{ old('name') }}">
            </div>
        </div>

        {{-- Permissions --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong><br/>
                @foreach($permissions as $permission)
                    <label class="mr-2">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                            {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}>
                        {{ $permission->name }}
                    </label>
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
