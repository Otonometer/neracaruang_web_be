@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Page
        </h1>--}}
        
        {{--@include('pages.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Page</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('pages.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('pages.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
