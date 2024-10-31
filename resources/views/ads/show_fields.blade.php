<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $ad->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $ad->title !!}</p>
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <br>
    <img src="{{ asset($ad->image) }}" alt="image" width="300px" height="auto">
</div>

<!-- Location Id Field -->
<div class="form-group">
    {!! Form::label('location_id', 'Location Id:') !!}
    <p>{!! @$location !!}</p>
</div>

<!-- Location Type Field -->
<div class="form-group">
    {!! Form::label('location_type', 'Location Type:') !!}
    <p class="text-capitalize">{!! $ad->location_type !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $ad->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $ad->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $ad->deleted_at !!}</p>
</div>
