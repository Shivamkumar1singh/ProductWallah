@component('mail::message')
# New Order Received

Hello {{ $vendor->name }},

You have received a new order for the following items:

@foreach ($items as $item)
- **{{ $item['name'] }}**
  - Quantity: {{ $item['quantity'] }}
  - Price: ₹{{ $item['price'] }}
@endforeach

**Customer Name:** {{ $order->name }}  
**Phone:** {{ $order->phone }}  
**Address:** {{ $order->address }}

Thanks,  
{{ config('app.name') }}
@endcomponent
