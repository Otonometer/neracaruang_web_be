{!! Form::open(['route' => ['moderators.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    {{-- <a href="{{ route('moderators.show', $id) }}" class='btn btn-outline-secondary btn-xs btn-icon'>
        <i class="fas fa-lock-open"></i>
    </a> --}}
    <a href="{{ route('moderators.edit', $id) }}" class='btn btn-outline-primary btn-xs btn-icon'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-outline-danger btn-xs btn-icon',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
