@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h4 class="mb-3">Coupon Details</h4>

    <table class="table table-bordered">
        <tr>
            <th>Code</th>
            <td>{{ $coupon->code }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ ucfirst($coupon->type) }}</td>
        </tr>
        <tr>
            <th>Value</th>
            <td>{{ $coupon->value }}</td>
        </tr>
        <tr>
            <th>Minimum Order</th>
            <td>{{ $coupon->min_order_amount ?? '—' }}</td>
        </tr>
        <tr>
            <th>Usage Limit</th>
            <td>{{ $coupon->usage_limit ?? 'Unlimited' }}</td>
        </tr>
        <tr>
            <th>Used Count</th>
            <td>{{ $coupon->used_count }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge {{ $coupon->is_active ? 'bg-success' : 'bg-danger' }}">
                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>
        </tr>
    </table>

    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>
@endsection
