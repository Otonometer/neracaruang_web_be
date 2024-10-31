@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Permission
        </h1>--}}
        
        {{--@include('permissions.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Permission</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('permissions.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('permissions.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
