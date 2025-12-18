@extends('layouts.admin.master')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.users.index') }}">
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

<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- Name --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Name" class="form-control">
            </div>
        </div>

        {{-- Email --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" class="form-control">
            </div>
        </div>

        {{-- Password --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" name="password" placeholder="Password" class="form-control">
                <small class="text-muted">Leave blank if you don’t want to change the password.</small>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
            </div>
        </div>

        {{-- Roles --}}
        <div class="col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                <select name="roles[]" class="form-control" multiple="multiple">
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" 
                            {{ (in_array($value, old('roles', $userRole ?? []))) ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
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
