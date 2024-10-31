@extends('layouts.app')

@section('contents')
    <div class="content content-components">
        <div class="container">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                        </ol>
                    </nav>
                    <!-- <h1 class="mg-b-0 tx-spacing--1">Permissions</h1> -->
                </div>
            </div>
            
            @include('flash::message')
            
            <h4 class="mg-b-10">Permissions</h4>

            <p class="mg-b-30">
                This is a list of your <code>Permissions</code>, you can manage by clicking on action buttons in this table.
            </p>

            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    
                </div>

                <div class="d-md-block">
                    <a class="btn btn-sm btn-primary btn-uppercase" href="{!! route('permissions.create') !!}"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>

            <div class="table-responsive">
                @include('permissions.table')
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

