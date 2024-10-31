@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Social Media
        </h1>--}}

        {{--@include('social_media.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Notification</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('notifications.show_fields')

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('notification.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
