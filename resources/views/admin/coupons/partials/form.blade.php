@php
    $coupon = $coupon ?? null;
@endphp

<div class="mb-3">
    <label>Code</label>
    <input type="text" name="code" class="form-control"
           value="{{ old('code', $coupon->code ?? '') }}">
</div>

<div class="mb-3">
    <label>Type</label>
    <select name="type" class="form-control">
        <option value="percentage" @selected(old('type', $coupon->type ?? '') === 'percentage')>
            Percentage
        </option>
        <option value="flat" @selected(old('type', $coupon->type ?? '') === 'flat')>
            Flat
        </option>
    </select>
</div>

<div class="mb-3">
    <label>Value</label>
    <input type="number" name="value" class="form-control"
           value="{{ old('value', $coupon->value ?? '') }}">
</div>

<div class="mb-3">
    <label>Minimum Order Amount</label>
    <input type="number" name="min_order_amount" class="form-control"
           value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}">
</div>

<div class="mb-3">
    <label>Start Date</label>
    <input type="date" name="start_date" class="form-control"
           value="{{ old('start_date', optional($coupon?->start_date)->format('Y-m-d')) }}">
</div>

<div class="mb-3">
    <label>End Date</label>
    <input type="date" name="end_date" class="form-control"
           value="{{ old('end_date', optional($coupon?->end_date)->format('Y-m-d')) }}">
</div>

<div class="mb-3">
    <label>Usage Limit</label>
    <input type="number" name="usage_limit" class="form-control"
           value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
</div>

<div class="mb-3">
    <label for="is_active" class="form-label">Status</label>

    <select name="is_active" id="is_active" class="form-select">
        <option value="1"
            {{ old('is_active', $coupon->is_active ?? 1) == 1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0"
            {{ old('is_active', $coupon->is_active ?? 1) == 0 ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>


