{!! Form::open(['route' => ['contents.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('content-show')
        <a href="{{ route('contents.show', $id) }}" class='btn btn-outline-secondary btn-xs btn-icon'>
            <i class="fa fa-eye"></i>
        </a>
    @endcan
    @can('content-edit')
        <a href="{{ route('contents.edit', $id) }}" class='btn btn-outline-primary btn-xs btn-icon'>
            <i class="fa fa-edit"></i>
        </a>
    @endcan
    @can('content-delete')
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-outline-danger btn-xs btn-icon',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endcan
</div>
{!! Form::close() !!}
