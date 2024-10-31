@extends('layouts.app')

@section('contents')
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Welcome Page</li>
            </ol>
            </nav>
            <h5 class="mg-b-0 tx-spacing--1">Welcome</h5>
        </div>
    </div>

    <div class="row row-xs">
        <div class="col-lg-12 col-xl-12 col-sm-12 tx-center pd-t-40">
          <h3>Neraca Ruang Content Management System</h3>
          <h5>Welcome <span class="tx-bold">{!! Auth::user()->name !!}</span></h5>
          <p class="tx-color-03 tx-12 mg-t-10">{!! @Auth::user()->roles[0]->name !!}</p>
        </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
      $(function(){
        'use strict'
      })
    </script>
@endsection
