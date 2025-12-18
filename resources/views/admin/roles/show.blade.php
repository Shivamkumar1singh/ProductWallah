@extends('layouts.admin.master')

@section('title', 'Show Role')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Show Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row mt-3">
    {{-- Name --}}
    <div class="col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $role->name }}
        </div>
    </div>

    {{-- Permissions --}}
    <div class="col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($role->permissions) && $role->permissions->isNotEmpty())
                @foreach($role->permissions as $permission)
                    <label class="badge bg-success">{{ $permission->name }}</label>
                @endforeach
            @else
                <span class="text-muted">No permissions assigned</span>
            @endif
        </div>
    </div>
</div>
@endsection
