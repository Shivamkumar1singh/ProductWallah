<?php

namespace App\DataTables\Vendor;

use App\Repositories\Vendor\OrderRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    public function query()
    {
        $repo = app(OrderRepository::class);
        return $repo->getOrdersQuery();
    }

    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('customer', fn($row) => $row->user ? $row->user->name : 'N/A')
            ->addColumn('total', function ($row) {
                $vendorId = auth('vendor')->id();
                $vendorTotal = $row->products
                    ->where('pivot.vendor_id', $vendorId)
                    ->sum(function($product) {
                        return $product->pivot->quantity * $product->pivot->price;
                    });
                return '₹' . number_format($vendorTotal, 2);
            })
            ->addColumn('payment_status', function ($row) {
                $color = match ($row->payment_status) {
                    'paid' => 'background-color:#d1e7dd;color:#0f5132',
                    'pending' => 'background-color:#fff3cd;color:#664d03',
                    default => 'background-color:#e2e3e5;color:#41464b',
                };
                return '<span class="badge" style="'.$color.'">' . ucfirst($row->payment_status) . '</span>';
            })
            ->addColumn('status', function ($row) {
                $colors = [
                    'pending' => 'background-color:#fff3cd;color:#664d03',
                    'processing' => 'background-color:#cff4fc;color:#055160',
                    'shipped' => 'background-color:#e2e3e5;color:#41464b',
                    'delivered' => 'background-color:#d1e7dd;color:#0f5132',
                    'cancelled' => 'background-color:#f8d7da;color:#842029',
                ];
                $color = $colors[$row->status] ?? 'background-color:#e2e3e5;color:#41464b';
                return '<span class="badge" style="'.$color.'">' . ucfirst($row->status) . '</span>';
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('d M Y'))
            ->addColumn('actions', function ($row) {
                $show = route('vendor.orders.show', $row->id);
                return '
                    <a href="'.$show.'" class="btn btn-sm btn-info">
                        <i class="ti ti-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-success update-status" data-id="'.$row->id.'">
                        <i class="ti ti-edit"></i>
                    </button>';
            })
            ->rawColumns(['payment_status', 'status', 'actions']);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => '#'],
            ['data' => 'customer', 'title' => 'Customer'],
            ['data' => 'payment_status', 'title' => 'Payment'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'created_at', 'title' => 'Date'],
            ['data' => 'actions', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
        ];
    }
}
