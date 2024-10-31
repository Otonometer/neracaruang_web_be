<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $province->id !!}</p>
</div>

<!-- Province Code Field -->
{{-- <div class="form-group">
    {!! Form::label('province_code', 'Province Code:') !!}
    <p>{!! $province->province_code !!}</p>
</div> --}}

<!-- Province Name Field -->
<div class="form-group">
    {!! Form::label('province_name', 'Province Name:') !!}
    <p>{!! $province->province_name !!}</p>
</div>

<!-- Icon Map Field -->
<div class="form-group">
    {!! Form::label('icon_map', 'Icon Map:') !!}
    <p>{!! $province->icon_map !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $province->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $province->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $province->deleted_at !!}</p>
</div>
