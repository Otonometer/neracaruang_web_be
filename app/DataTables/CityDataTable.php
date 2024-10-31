<?php

namespace App\DataTables;

use App\Models\City;
use App\Models\Province;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CityDataTable extends DataTable
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
            ->editColumn('province_code', function($item){
                $province = Province::where('id', $item->province_code)->first();
                return $province->province_name;
            })
            ->editColumn('icon_map', function($item){
                return '<img src="'.asset($item->icon_map).'" alt="" width="150px">';
            })
            ->filterColumn('province_code', function($query, $keyword) {
                $tes = Province::where('province_name','like','%'.$keyword.'%')->pluck('id');
                foreach($tes as $val){
                    $query->orWhere('province_code', 'LIKE', '%'.$val.'%');
                }
            })
            ->editColumn('icon_blue', function($item) {
                $icon = @$item->blue()->image;
                return '<img class="d-block mx-auto" src="'.asset(@$icon).'" alt="" width="50px">';
            })
            ->editColumn('icon_green', function($item) {
                $icon = @$item->green()->image;
                return '<img class="d-block mx-auto" src="'.asset(@$icon).'" alt="" width="50px">';
            })
            ->addColumn('action', 'cities.datatables_actions')
            ->rawColumns(['action','icon_map','province_code','icon_blue','icon_green']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(City $model)
    {
        return $model->newQuery()->orderBy('id','asc');
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
            'province_code' => ['title' => 'Province', 'data' => 'province_code'],
            'city_name',
            'icon_blue',
            'icon_green'
            // 'icon_map' => ['searchable' => false,'orderable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename():string
    {
        return 'citiesdatatable_' . time();
    }
}
