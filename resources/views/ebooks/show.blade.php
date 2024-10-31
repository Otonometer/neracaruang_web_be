@extends('layouts.app')

@section('contents')
    {{--<section class="content-header">
        <h1>
            E-Book
        </h1>--}}

        {{--@include('ebook.version')--}}
    {{--</section>--}}
    <div class="content">
        <h4 class="mg-b-30">E-Book</h4>

        <div class="box box-primary">
            <div class="box-body">
                @include('ebooks.show_fields')

                <div class="clearfix"></div>
                <hr>

                <a href="{!! route('ebook.index') !!}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
@endsection
