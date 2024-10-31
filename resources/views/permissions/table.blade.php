@section('styles')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%'], true) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
    </script>
@endsection
