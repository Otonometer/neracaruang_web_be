<?php

namespace App\DataTables;

use App\Models\Notification;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class NotificationDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'notifications.datatables_actions')
        ->editColumn('image_uri', function($item){
            return '<img src="'.asset($item->image_uri).'" alt="" width="150px">';
        })->editColumn('is_active', function($item){
            return $item->is_active == 1 ? '<b class="text-success">Active</b>' : '<b class="text-danger">Inactive</b>';
        })->editColumn('link_uri', function ($item) {
            return '<a href="'.$item->link_uri.'" target="_blank">'.$item->link_uri.'</a>';
        })->rawColumns(['action','image_uri','is_active', 'link_uri']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EBook $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Notification $model)
    {
        return $model->newQuery()->orderBy('created_at', 'desc');
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
                    // 'reset',
                    // 'reload',
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
            'header' => ['name' => 'type', 'data' => 'type', 'title' => 'Header'],
            'title',
            'image' => ['name' => 'image_uri', 'data' => 'image_uri', 'title' => 'Image'],
            'description',
            'link_uri' => ['name' => 'link_uri', 'data' => 'link_uri', 'title' => 'Url'],
            'status' => ['name' => 'is_active', 'data' => 'is_active', 'title' => 'Status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename():string
    {
        return 'notificationdatatable_' . time();
    }
}