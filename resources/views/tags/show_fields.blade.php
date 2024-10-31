<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $tag->title !!}</p>
</div>

<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{!! $tag->slug !!}</p>
</div>

<div class="form-group">
    {!! Form::label('category', 'Category:') !!}
    <p>{!! ucwords($tag->category_name) !!}</p>
</div>

<div class="form-group">
    <label for="icon" class="d-block">Icon:</label>
    <img src="{{ asset($tag->icon) }}" alt="" class="img-thumbnail" height="200" width="200">
</div>