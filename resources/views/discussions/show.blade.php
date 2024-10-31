@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Discussion
        </h1>--}}
        
        {{--@include('discussions.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Discussion</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('discussions.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('discussions.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
