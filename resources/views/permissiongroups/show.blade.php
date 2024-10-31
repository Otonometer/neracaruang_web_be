@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Permissiongroup
        </h1>--}}
        
        {{--@include('webcore.permissiongroups.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Permissiongroup</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('permissiongroups.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('permissiongroups.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
