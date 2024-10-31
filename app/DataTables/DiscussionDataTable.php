<?php

namespace App\DataTables;

use App\Models\Discussion;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class DiscussionDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'discussions.datatables_actions')
            ->editColumn('image', function($item) {
                return '<img src="'.asset($item->image).'" width="150px">';
            })
            ->editColumn('publish_date_start', function($item) {
                return Carbon::parse($item->publish_date_start)->format("Y-m-d g:i A");
            })
            ->editColumn('publish_date_end', function($item) {
                return Carbon::parse($item->publish_date_end)->format("Y-m-d g:i A");
            })
            ->rawColumns(['action','image','publish_date_start','publish_date_end']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Discussion $model)
    {
        return $model->newQuery()->with(['moderator','co_moderator']);
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
            'slug',
            'image',
            'reads',
            'likes',
            'moderator.name',
            'co_moderator.name',
            'publish_date_start',
            'publish_date_end',
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
        return 'discussionsdatatable_' . time();
    }
}
