<?php

namespace App\DataTables;

use App\Models\Content;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ContentDataTable extends DataTable
{
    public function __construct(private int $typeId)
    {
    }
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
            ->addColumn('action', 'contents.datatables_actions')
            ->editColumn('publish_date', function($item) {
                return Carbon::parse($item->publish_date)->format('d-F-Y');
            })
            ->filterColumn('location_id',function($query,$keyword){
                $query->whereHas('location',function($query) use($keyword){
                    $query->where('city_name','like',"%{$keyword}%");
                });
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Content $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Content $model)
    {
        return $model->newQuery()->where('page_type_id',$this->typeId)
            ->select(['id','title','reads','likes','publish_date','status','location_id']);
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
                            });name
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
            'location' => ['data' => 'location.city_name' ,'title' => 'City','name' => 'location_id'],
            'reads',
            'likes',
            'publish_date',
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
        return 'contentsdatatable_' . time();
    }
}
