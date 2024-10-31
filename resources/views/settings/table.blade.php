@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/dxDataGrid/css/dx.common.css') }}" />
    <link rel="dx-theme" data-theme="generic.light" href="{{ asset('vendor/dxDataGrid/css/dx.light.css') }}" />
    <style>
        .dx-datagrid .dx-data-row > td.bullet {
            padding-top: 0;
            padding-bottom: 0;
        }
        .dx-datagrid-content .dx-datagrid-table .dx-row .dx-command-edit {
            width: auto;
            min-width: 140px;
        }
    </style>
@endsection

<div class="dx-viewport">
    <div class="demo-container">
        <div id="gridContainer"></div>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('vendor/dxDataGrid/js/jszip/3.1.5/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/dxDataGrid/js/20.1.6/dx.all.js') }}"></script>
    <script src="{{ asset('vendor/dxDataGrid/js/babel-polyfill/7.4.0/polyfill.min.js') }}"></script>
    <script src="{{ asset('vendor/dxDataGrid/js/exceljs/3.3.1/exceljs.min.js') }}"></script>
    <script src="{{ asset('vendor/dxDataGrid/js/FileSaver.js/1.3.8/FileSaver.min.js') }}"></script>
    
    <script>
        function addImage(url, workbook, worksheet, excelCell, resolve) {
            var xhr = new XMLHttpRequest()
            xhr.open('GET', url)
            xhr.responseType = 'blob'
            xhr.onload = function () {
                var reader = new FileReader();
                reader.readAsDataURL(xhr.response);
                reader.onloadend = function() {
                    var base64data = reader.result;                
                    const image = workbook.addImage({
                        base64: base64data,
                        extension: 'png',
                    });

                    worksheet.getRow(excelCell.row).height = 75;
                    worksheet.addImage(image, {
                        tl: { col: excelCell.col - 1, row: excelCell.row - 1 },
                        br: { col: excelCell.col, row: excelCell.row }
                    });

                    resolve();
                }
            }
            xhr.onerror = function () {
                console.error('could not add image to excel cell')
            };
            xhr.send();
        }

        var doDeselection;
        function logEvent(eventName) {
            var logList = $("#events ul"),
                newItem = $("<li>", { text: eventName });

            logList.prepend(newItem);
        }

        $("#gridContainer").dxDataGrid({
            dataSource: @json($settings),
            columnAutoWidth: true,
            allowColumnResizing: true,
            columnResizingMode: 'widget', // or 'nextColumn'
            // rowAlternationEnabled: true,
            allowColumnReordering: true,
            columnChooser: {
                enabled: true,
                mode: "dragAndDrop" // or "select"
            },
            hoverStateEnabled: true, 
            // showBorders: true,
            // selection: {
            //     mode: 'multiple'
            // },
            // // {{--@role('superadministrator')--}}
            // selection: {
            //     mode: "multiple",
            //     // allowSelectAll : false,
            //     selectAllMode: 'page',
            //     showCheckBoxesMode : "always"
            // },
            // // {{--@endrole--}}
            export: {
                enabled: true,
                fileName: 'settings',
                // allowExportSelectedData: true,
            },
            grouping: {
                autoExpandAll: false,
                contextMenuEnabled: true
            },
            groupPanel: {
                visible: true
            },       
            searchPanel: {
                visible: true
            },   
            filterRow: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            columnFixing: {
                enabled: true
            },
            // height: 420,            
            paging: {
                pageSize: 10
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [10, 50, 100],
                showInfo: true
            },
            keyExpr: "id",
            columns: [
                {  
                    caption: '#',
                    // allowEditing: false,
                    // allowSorting: false,
                    cellTemplate: function(cellElement, cellInfo) {  
                        cellElement.text(cellInfo.row.rowIndex + 1);
                        // cellElement.html('<span>'+(parseInt(cellInfo.rowIndex, 10)+1)+'</span>');
                    }
                },
                {
                    dataField: 'id',
                    visible: false, 
                    // sortIndex: 0,
                    // sortOrder: "desc"
                },
                // "name",
                // "description",
                "created_by",
                "created_at",
                "updated_by",
                "updated_at"
            ],
            editing: {
                mode: "row",
                allowDeleting: function(e) {
                    return true;
                },
            },
            onExporting: e => {
                var workbook = new ExcelJS.Workbook();    
                var worksheet = workbook.addWorksheet('Main sheet');
                var PromiseArray = [];
                
                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet: worksheet,
                    autoFilterEnabled: true,
                    customizeCell: (options) => {
                        var { excelCell, gridCell } = options;
                        if(gridCell.rowType === "data") {
                            if(gridCell.column.dataField === "image") {
                                excelCell.value = undefined;
                                PromiseArray.push(
                                    new Promise((resolve, reject) => {
                                        addImage(gridCell.value, workbook, worksheet, excelCell, resolve); 
                                    })
                                );
                            }
                        }

                    }
                }).then(function() {
                    Promise.all(PromiseArray).then(() => {
                        workbook.xlsx.writeBuffer().then(function (buffer) {
                            saveAs(new Blob([buffer], { type: "application/octet-stream" }), "settings.xlsx");
                        });
                    });
                });
                e.cancel = true;
            },
            onCellPrepared: function (e) {
                if (e.rowType === "data" && e.column.command === "edit") {
                    e.cellElement.prepend('&nbsp;');
                    $('<a/>').addClass('dx-link')
                        .text('Edit')
                        .on('dxclick', function () {
                            window.location = '{{url("settings")}}/'+e.row.data.id+'/edit'
                        })
                        .prependTo(e.cellElement);
                }
            },
            onRowRemoved: function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url()->current() }}/'+JSON.stringify(e.data.id),
                    type: 'delete'
                }).success(function(res) {
                    // location = '{{ url()->current() }}';
                }).error(function(res) {
                    location = '{{ url()->current() }}';
                });
                
                logEvent("RowRemoved");
            },
        });
    </script>
@endsection
