@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Tag
        </h1>--}}
        
        {{--@include('tags.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Tag</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('tags.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('tags.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
