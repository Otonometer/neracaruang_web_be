<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $discussionSuggestion->id !!}</p>
</div>

<!-- Topic Field -->
<div class="form-group">
    {!! Form::label('topic', 'Topic:') !!}
    <p>{!! $discussionSuggestion->topic !!}</p>
</div>

<!-- Abstract Field -->
<div class="form-group">
    {!! Form::label('abstract', 'Abstract:') !!}
    <p>{!! $discussionSuggestion->abstract !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{!! $discussionSuggestion->user_id !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $discussionSuggestion->status !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $discussionSuggestion->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $discussionSuggestion->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $discussionSuggestion->deleted_at !!}</p>
</div>

