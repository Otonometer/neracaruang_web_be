<?php

namespace App\DataTables;

use App\Models\EBook;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class EBookDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'ebooks.datatables_actions')
        ->editColumn('image_uri', function($item){
            return '<img src="'.asset($item->image_uri).'" alt="" width="150px">';
        })->editColumn('is_active', function($item){
            return $item->is_active == 1 ? '<b class="text-success">Active</b>' : '<b class="text-danger">Inactive</b>';
        })->editColumn('download_uri', function ($item) {
            return '<a href="'.$item->download_uri.'" target="_blank">View</a>';
        })->editColumn('description', function($item) {
                return Str::limit($item->description, 100); // Adjust the limit as needed
        })->rawColumns(['action','image_uri','is_active', 'download_uri']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EBook $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EBook $model)
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
            'title',
            'author',
            'description',
            'image' => ['name' => 'image_uri', 'data' => 'image_uri', 'title' => 'Image'],
            'pdf' => ['name' => 'download_uri', 'data' => 'download_uri', 'title' => 'PDF'],
            'reads' => ['name' => 'view_count', 'data' => 'view_count', 'title' => 'Reads'],
            'downloads' => ['name' => 'download_count', 'data' => 'download_count', 'title' => 'Downloads'],
            'status'=> ['name' => 'is_active', 'data' => 'is_active', 'title' => 'Status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename():string
    {
        return 'ebookdatatable_' . time();
    }
}
