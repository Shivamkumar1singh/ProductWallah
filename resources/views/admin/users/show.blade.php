@extends('layouts.admin.master')

@section('title', 'Show User')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Show User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.index') }}">
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
            {{ $user->name }}
        </div>
    </div>

    {{-- Email --}}
    <div class="col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email }}
        </div>
    </div>

    {{-- Roles --}}
    <div class="col-md-12">
        <div class="form-group">
            <strong>Roles:</strong>
            @if($user->getRoleNames()->isNotEmpty())
                @foreach($user->getRoleNames() as $role)
                    <label class="badge bg-success">{{ $role }}</label>
                @endforeach
            @else
                <span class="text-muted">No roles assigned</span>
            @endif
        </div>
    </div>
</div>
@endsection
