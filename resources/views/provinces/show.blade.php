@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Province
        </h1>--}}
        
        {{--@include('provinces.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Province</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('provinces.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('provinces.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
