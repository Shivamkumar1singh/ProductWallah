@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h4>Create Coupon</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('admin.coupons.store') }}">
        @csrf

        @include('admin.coupons.partials.form')

        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
