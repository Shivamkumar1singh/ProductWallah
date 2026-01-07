<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Vendor\Vendor;      
use App\Mail\VendorOrderMail;
use Illuminate\Support\Facades\Mail;
use App\Repositories\OrderRepository;

class OrderService
{
    protected $repo;

    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    public function changeStatus(Order $order, string $status)
    {
        return $this->repo->updateStatus($order, $status);
    }

    public function getDetails(Order $order)
    {
        return $this->repo->getOrderDetails($order);
    }

    public function getStatusCounts()
    {
        return $this->repo->getStatusCounts();
    }

    // In App\Services\OrderService.php

    public function sendVendorOrderEmail(Order $order): void
    {
        $items = $order->items;

        if (!is_array($items) || empty($items)) {
            return;
        }

        // Group items by vendor_id
        $itemsByVendor = collect($items)->groupBy('vendor_id');

        foreach ($itemsByVendor as $vendorId => $vendorItems) {

            $vendor = Vendor::find($vendorId);
            if (!$vendor || !$vendor->email) {
                continue;
            }

            // Send ONLY that vendor's items
            Mail::to($vendor->email)
                ->send(new VendorOrderMail($order, $vendor, $vendorItems->values()->toArray()));
        }
    }

}
 