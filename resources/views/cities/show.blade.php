@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            City
        </h1>--}}
        
        {{--@include('cities.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">City</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('cities.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('cities.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
