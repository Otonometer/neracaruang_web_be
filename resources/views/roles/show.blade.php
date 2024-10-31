@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Role
        </h1>--}}
        
        {{--@include('roles.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Role</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('roles.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('roles.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
