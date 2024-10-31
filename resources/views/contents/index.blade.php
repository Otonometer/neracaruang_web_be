@extends('layouts.app')

@section('contents')
    <div class="content content-components">
        <div class="container">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $contentTypesEnum::tryFrom($typeId)->title() }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @include('flash::message')

            <h4 class="mg-b-10">{{ $contentTypesEnum::tryFrom($typeId)->title() }}</h4>

            <p class="mg-b-30">
                This is a list of your <code>{{ $contentTypesEnum::tryFrom($typeId)->title() }}</code>, you can manage by clicking on action buttons in this table.
            </p>

            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>

                </div>

                <div class="d-none d-md-block">
                    @can('content-create')
                        <button class="btn btn-success btn-sm"
                            type="button" data-toggle="modal"
                            data-target="#metaModal">Meta
                        </button>
                        <a class="btn btn-sm btn-primary btn-uppercase" href="{!! route('contents.create', $contentTypesEnum::tryFrom($typeId)->slug() ) !!}"><i class="fa fa-plus"></i> Add New</a>
                    @endcan
                </div>
            </div>

            <div class="table-responsive">
                @include('contents.table')
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@include('contents.modal_meta')
@section('script-menu')
    <script>
        $(document).on('click','#btnSubmitMeta',(e) => {
            $.ajax({
                method : "POST",
                url : "/metas",
                data : {
                    _token : "{{csrf_token()}}",
                    title : $('#formMeta input[name="title"]').val(),
                    description : $('#formMeta textarea[name="description"]').val(),
                    keyword : $('#formMeta input[name="keyword"]').val(),
                    page_id : $('#formMeta input[name="page_id"]').val(),
                },
                success : (resp) => {
                    console.log(resp.message)
                },
                error : (err) => {
                    console.log(err)
                }
            })

        })
    </script>
@endsection
