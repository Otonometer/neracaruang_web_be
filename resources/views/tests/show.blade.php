@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Test
        </h1>--}}
        
        {{--@include('tests.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Test</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('tests.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('tests.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
