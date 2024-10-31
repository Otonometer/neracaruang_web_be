<?php

namespace App\DataTables;

use App\Models\Ad;
use App\Models\City;
use App\Models\Province;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->editColumn('image', function($item) {
                return '<img src="'.$item->image.'" class="" alt="image" width="250px" height="auto">';
            })
            ->editColumn('location_id', function($item) {
                if ($item->location_type == 'province') {
                    $data = Province::select('id', 'province_name')->where('id', $item->location_id)->first();
                    return @$data->province_name;
                } else if ($item->location_type == 'city') {
                    $data = City::select('id', 'city_name')->where('id', $item->location_id)->first();
                    return @$data->city_name;
                }
            })
            ->editColumn('location_type', function($item) {
                if ($item->location_type == 'province') {
                    $data = 'Provinsi';
                } else if ($item->location_type == 'city') {
                    $data = 'Kota';
                } else {
                    $data = 'Nasional';
                }
                return '<span class="text-capitalize">'.$data.'</span>';
            })
            ->editColumn('date_start', function($item) {
                return Carbon::parse($item->date_start)->format('d M Y');
            })
            ->editColumn('date_end', function($item) {
                return Carbon::parse($item->date_end)->format('d M Y');
            })
            ->addColumn('action', 'ads.datatables_actions')
            ->rawColumns(['image', 'location_type', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ad $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
            ->parameters([
                'dom'     => 'Bfrtip',
                'order'   => [[0, 'desc']],
                'buttons' => [
                    'export',
                    'reset',
                    'reload',
                ],
                'initComplete' => "function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var input = document.createElement(\"input\");
                        if($(column.header()).attr('title') !== 'Action'){
                            $(input).appendTo($(column.header()))
                            .on('keyup change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        }
                    });
                }",
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'title',
            'image',
            'location_id' => ['title' => 'Location'],
            'location_type' => ['title' => 'Page'],
            'date_start',
            'date_end',
            // 'link',
            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename():string
    {
        return 'adsdatatable_' . time();
    }
}
