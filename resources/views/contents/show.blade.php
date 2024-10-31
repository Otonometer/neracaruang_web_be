@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Content
        </h1>--}}
        
        {{--@include('contents.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Content</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('contents.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('contents.index',\App\Enums\ContentTypes::tryFrom($content->page_type_id)->slug()) !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
