<?php

namespace App\DataTables;

use App\Models\Coupon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
{
    /**
     * Build the query
     */
    public function query()
    {
        $query = Coupon::query()->latest();
    
        if (request()->status === 'active') {
            $query->where('is_active', 1);
        }
    
        if (request()->status === 'inactive') {
            $query->where('is_active', 0);
        }
    
        return $query;
    }


    /**
     * Build DataTable
     */
    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('type', function ($row) {
                return ucfirst($row->type);
            })

            ->editColumn('value', function ($row) {
                return $row->type === 'percentage'
                    ? $row->value . '%'
                    : '₹' . number_format($row->value, 2);
            })

            ->addColumn('status', function ($row) {
                // Same inline badge style as Orders
                if ($row->is_active) {
                    $color = 'background-color:#d1e7dd;color:#0f5132'; // green
                    $label = 'Active';
                } else {
                    $color = 'background-color:#f8d7da;color:#842029'; // red
                    $label = 'Inactive';
                }

                return '<span class="badge" style="'.$color.'">'.$label.'</span>';
            })

            ->editColumn('used_count', function ($row) {
                return $row->used_count ?? 0;
            })

            ->editColumn('end_date', function ($row) {
                return optional($row->end_date)->format('d M Y') ?? '-';
            })

            ->addColumn('actions', function ($row) {
                $edit = route('admin.coupons.edit', $row->id);
                $toggle = route('admin.coupons.toggle', $row->id);

                return '
                    <a href="'.$edit.'" class="btn btn-sm btn-success">
                        <i class="ti ti-edit"></i>
                    </a>

                    <form action="'.route('admin.coupons.destroy', $row->id).'"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm(\'Are you sure you want to delete this coupon?\')">
                    
                        '.csrf_field().'
                        '.method_field('DELETE').'
                    
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                ';
            })

            ->rawColumns(['status', 'actions']);
    }

    /**
     * DataTable HTML builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('couponTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0);
    }

    /**
     * Columns definition
     */
    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'No.', 'orderable' => false, 'searchable' => false],
            ['data' => 'code', 'title' => 'Code'],
            ['data' => 'type', 'title' => 'Type'],
            ['data' => 'value', 'title' => 'Value'],
            ['data' => 'used_count', 'title' => 'Used'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'actions', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
        ];
    }
}
