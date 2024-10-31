@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Category
        </h1>--}}
        
        {{--@include('categories.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Category</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('categories.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('categories.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
