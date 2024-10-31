{!! Form::open(['route' => ['permissiongroups.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('permissiongroup-show')
        <a href="{{ route('permissiongroups.show', $id) }}" class='btn btn-outline-secondary btn-xs btn-icon'>
            <i class="fa fa-eye"></i>
        </a>
    @endcan
    @can('permissiongroup-edit')
        <a href="{{ route('permissiongroups.edit', $id) }}" class='btn btn-outline-primary btn-xs btn-icon'>
            <i class="fa fa-edit"></i>
        </a>
    @endcan
    @can('permissiongroup-delete')
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-outline-danger btn-xs btn-icon',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endcan
</div>
{!! Form::close() !!}
