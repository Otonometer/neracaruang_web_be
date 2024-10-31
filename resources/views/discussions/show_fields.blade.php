<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $discussion->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $discussion->title !!}</p>
</div>

<!-- Slug Field -->
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{!! $discussion->slug !!}</p>
</div>

<!-- Summary Field -->
<div class="form-group">
    {!! Form::label('summary', 'Summary:') !!}
    <p>{!! $discussion->summary !!}</p>
</div>

<!-- Content Field -->
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}
    <p>{!! $discussion->content !!}</p>
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <p>{!! $discussion->image !!}</p>
</div>

<!-- Reads Field -->
<div class="form-group">
    {!! Form::label('reads', 'Reads:') !!}
    <p>{!! $discussion->reads !!}</p>
</div>

<!-- Likes Field -->
<div class="form-group">
    {!! Form::label('likes', 'Likes:') !!}
    <p>{!! $discussion->likes !!}</p>
</div>

<!-- Moderator Field -->
<div class="form-group">
    {!! Form::label('moderator', 'Moderator:') !!}
    <p>{!! $discussion->moderator !!}</p>
</div>

<!-- Co Moderator Field -->
<div class="form-group">
    {!! Form::label('co_moderator', 'Co Moderator:') !!}
    <p>{!! $discussion->co_moderator !!}</p>
</div>

<!-- Publish Date Start Field -->
<div class="form-group">
    {!! Form::label('publish_date_start', 'Publish Date Start:') !!}
    <p>{!! $discussion->publish_date_start !!}</p>
</div>

<!-- Publish Date End Field -->
<div class="form-group">
    {!! Form::label('publish_date_end', 'Publish Date End:') !!}
    <p>{!! $discussion->publish_date_end !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $discussion->status !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $discussion->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $discussion->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $discussion->deleted_at !!}</p>
</div>

