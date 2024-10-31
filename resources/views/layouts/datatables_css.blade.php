<!-- DataTable Bootstrap -->
<link rel="stylesheet" href="{{ asset('vendor/dashforge/lib/datatables/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/dashforge/lib/datatables/buttons/css/buttons.bootstrap.min.css') }}">
<style>
    table.dataTable thead .sorting_asc, table.dataTable thead .sorting, table.dataTable thead .sorting_desc {
        background-image: none !important;
    }
    table.dataTable thead th input{
        display: block;
        width: 90%;
        margin-right: 5px;
    }
    table.dataTable th span, table.dataTable td span{
        display: block;
    }
    th span.one-line{
        margin-bottom: 19px;
    }
    .table thead th {
        vertical-align: top !important;
    }
    .dataTables_filter{
        display: none;
    }
    table.dataTable, table.dataTable th, table.dataTable td {
        font-size: 13px;
    }

</style>
