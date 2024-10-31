@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            Discussion Suggestion
        </h1>--}}
        
        {{--@include('discussion_suggestions.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">Discussion Suggestion</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('discussion_suggestions.show_fields')                

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('discussionSuggestions.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
