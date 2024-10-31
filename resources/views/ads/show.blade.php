@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Ad
        </h1>--}}
        
        {{--@include('ads.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Ad</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('ads.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('ads.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
