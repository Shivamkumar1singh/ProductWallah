@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h4>Edit Coupon</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST"
          action="{{ route('admin.coupons.update', $coupon) }}">
        @csrf
        @method('PUT')

        @include('admin.coupons.partials.form', ['coupon' => $coupon])

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
