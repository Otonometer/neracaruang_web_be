<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $content->title !!}</p>
</div>

<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{!! $content->slug !!}</p>
</div>

<div class="form-group">
    {!! Form::label('summary', 'Summary:') !!}
    <p>{!! $content->summary !!}</p>
</div>

<div class="form-group">
    {!! Form::label('content', 'Content:') !!}
    <p>{!! $content->content !!}</p>
</div>

@if ($content->page_type_id === \App\Enums\ContentTypes::VIDEO->value)
    <div class="form-group">
        {!! Form::label('video', 'Video:') !!}
        <p>{!! $content->video !!}</p>
    </div>
@endif

<div class="form-group">
    {!! Form::label('content_type', 'Content Type:') !!}
    <p>{!! \App\Enums\ContentTypes::tryFrom($content->page_type_id)->title() !!}</p>
</div>

<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <img src="{{ asset($content->image) }}" alt="">
</div>

<div class="form-group">
    {!! Form::label('location', 'Location:') !!}
    <p>{!! $content->location->city_name !!}</p>
</div>

<div>
    @foreach ($content->tags as $tag)
        <p>{{ $tag->title }}</p>
    @endforeach
</div>

<div class="form-group">
    {!! Form::label('reads', 'Reads:') !!}
    <p>{!! $content->reads !!}</p>
</div>

<div class="form-group">
    {!! Form::label('likes', 'Likes:') !!}
    <p>{!! $content->likes !!}</p>
</div>
