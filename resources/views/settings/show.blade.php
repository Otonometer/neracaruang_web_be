@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Setting
        </h1>--}}
        
        {{--@include('settings.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Setting</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('settings.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('settings.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
