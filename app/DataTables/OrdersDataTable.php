<?php

namespace App\DataTables;

use App\Repositories\OrderRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    public function query()
    {
        // Resolve repository (constructor does not work in Datatables)
        $repo = app(OrderRepository::class);
        return $repo->getOrdersQuery();
    }

    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->addColumn('customer', function ($row) {
                return $row->user ? $row->user->name : 'N/A';
            })

            // ->addColumn('payment_status', function ($row) {
            //     $color = match ($row->payment_status) {
            //         'paid' => 'bg-light-success',
            //         'pending' => 'bg-light-warning',
            //         default => 'bg-light-secondary',
            //     };
            //     return '<span class="badge ' . $color . '">' . ucfirst($row->payment_status) . '</span>';
            // })

            // ->addColumn('status', function ($row) {
            //     $badgeClass = match ($row->status) {
            //         'pending' => 'bg-light-warning',
            //         'processing' => 'bg-light-info',
            //         'shipped' => 'bg-light-primary',
            //         'delivered' => 'bg-light-success',
            //         'cancelled' => 'bg-light-danger',
            //         default => 'bg-light-secondary',
            //     };
            //     return '<span class="badge ' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
            // })


            ->addColumn('payment_status', function ($row) {
    // Manual badge colors
    if ($row->payment_status === 'paid') {
        $color = 'background-color:#d1e7dd;color:#0f5132'; // green
    } elseif ($row->payment_status === 'pending') {
        $color = 'background-color:#fff3cd;color:#664d03'; // yellow
    } else {
        $color = 'background-color:#e2e3e5;color:#41464b'; // gray
    }
    return '<span class="badge" style="'.$color.'">' . ucfirst($row->payment_status) . '</span>';
})

->addColumn('status', function ($row) {
    // Manual badge colors
    switch ($row->status) {
        case 'pending':
            $color = 'background-color:#fff3cd;color:#664d03'; // yellow
            break;
        case 'processing':
            $color = 'background-color:#cff4fc;color:#055160'; // cyan
            break;
        case 'shipped':
            $color = 'background-color:#e2e3e5;color:#41464b'; // grey
            break;
        case 'delivered':
            $color = 'background-color:#d1e7dd;color:#0f5132'; // green
            break;
        case 'cancelled':
            $color = 'background-color:#f8d7da;color:#842029'; // red
            break;
        default:
            $color = 'background-color:#e2e3e5;color:#41464b'; // gray
    }
    return '<span class="badge" style="'.$color.'">' . ucfirst($row->status) . '</span>';
})


            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })

            ->addColumn('actions', function ($row) {
                $show = route('admin.orders.show', $row->id);
                return '
                    <a href="'.$show.'" class="btn btn-sm btn-info">
                        <i class="ti ti-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-success update-status" data-id="'.$row->id.'">
                        <i class="ti ti-edit"></i>
                    </button>                    
                    
                ';
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
