@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Social Media
        </h1>--}}
        
        {{--@include('social_media.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Social Media</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('social_media.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('socialMedia.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
