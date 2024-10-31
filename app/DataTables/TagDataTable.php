<?php

namespace App\DataTables;

use App\Enums\SubjectTypes;
use App\Models\Tag;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class TagDataTable extends DataTable
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
        ->addColumn('action', 'tags.datatables_actions')
        ->editColumn('icon_blue', function($item) {
            $icon = @$item->blue()->image;
            return '<img class="d-block mx-auto" src="'.asset(@$icon).'" alt="" width="50px">';
        })
        ->editColumn('icon_green', function($item) {
            $icon = @$item->green()->image;
            return '<img class="d-block mx-auto" src="'.asset(@$icon).'" alt="" width="50px">';
        })
        ->filterColumn('category', fn ($query,$keyword) => $query->where('category_id',SubjectTypes::getValueFromTitle($keyword)))
        ->orderColumn('category', fn ($query,$order) => $query->orderBy('category_id',$order))
        ->rawColumns(['action','category','icon_blue','icon_green']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tag $model)
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
            'title' => ['title' => 'title', 'data' => 'title'],
            'slug' => ['title' => 'Slug', 'data' => 'slug'],
            'category' => ['title' => 'Category', 'data' => 'category_name', 'name' => 'category'],
            'icon_blue',
            'icon_green'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename():string
    {
        return 'tagsdatatable_' . time();
    }
}
