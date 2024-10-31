@extends('layouts.app')

@section('contents')
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
            </nav>
        </div>
    </div>

    @include('flash::message')
    @include('dashforge-templates::common.errors')

    <h4 class="mg-b-10">Edit Profile</h4>
    <div style="margin-right: -15px;margin-left: -15px;">
        <div data-label="Create" class="df-example demo-forms services-forms">
            {!! Form::open(['route' => 'profile.submit', 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-sm-8">
                    <!-- Name Field -->
                    <div class="form-group col-sm-10">
                        {!! Form::label('name', 'Name:', ['class' => 'd-block']) !!}
                        {!! Form::text('name', @$userlogin->name, ['class' => 'form-control']) !!}
                    </div>
            
                    <!-- Email Field -->
                    <div class="form-group col-sm-10">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', @$userlogin->email, ['class' => 'form-control']) !!}
                    </div>
                    <hr>

                    <p>These Field For change Password</p>
                    <!-- Password Field -->
                    <div class="form-group col-sm-10">
                        {!! Form::label('password', 'Password:', ['class' => 'd-block']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <!-- Password2 Field -->
                    <div class="form-group col-sm-10">
                        {!! Form::label('password2', 'Retype Password:', ['class' => 'd-block']) !!}
                        {!! Form::password('password2', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-3">
                    <!-- Image Field -->
                    <div class="form-group col-sm-12 col-md-12 col-lg-12">
                        {!! Form::label('image', 'Image/Avatar:', ['class' => 'd-block']) !!}
                        @if (!empty($vendor->logo))
                            <img src="{{ asset('storage/users/'.$userlogin->image) }}" height="200" width="250" alt="" title="" />
                        @endif
                        {!! Form::file('image', ['class' => 'dropify','id' => 'input-file-now', 'data-default-file' => $userlogin->image ? asset('storage/users/'.$userlogin->image) : '', 'data-allowed-file-extensions' => 'png jpg jpeg', 'data-max-file-size' => '1M']) !!}
                        <div class="alert alert-info mg-t-10" role="alert">
                            <span class="d-block tx-12">Only <b>.png|.jpg|.jpeg</b> Allowed</span>
                            <span class="d-block tx-12">Max Filesize <b>1MB</b></span>
                        </div>
                        
                    </div>
                </div>

                <div class="clearfix"></div>
                <hr>
                
                <!-- Submit Field -->
                <div class="col-sm-12">
                    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $('.dropify').dropify({
                messages: {
                    default: 'Drag and drop file here or click',
                    replace: 'Drag and drop file here or click to Replace',
                    remove:  'Remove',
                    error:   'Sorry, the file is too large'
                }
            });
        });
    </script>
@endsection
