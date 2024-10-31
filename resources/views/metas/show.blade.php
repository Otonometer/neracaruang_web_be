@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Meta
        </h1>--}}
        
        {{--@include('metas.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Meta</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('metas.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('metas.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
