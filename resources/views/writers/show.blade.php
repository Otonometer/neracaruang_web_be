@extends('layouts.app')

@section('contents')
    <div class="content">
        <div class="container">
            @include('dashforge-templates::common.errors')

            <h4 id="section1" class="mg-b-10">User</h4>
                @include('writers.show_fields')
        </div>
    </div>
    <!-- /.content -->
@endsection
