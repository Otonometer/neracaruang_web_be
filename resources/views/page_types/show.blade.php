@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Page Type
        </h1>--}}
        
        {{--@include('page_types.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Page Type</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('page_types.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('pageTypes.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
