<div class="col-sm-12">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('name', 'Name:', ['class' => 'd-block']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Group Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('permission_group_id', 'Group:', ['class' => 'd-block']) !!}
            {!! Form::select('permission_group_id', $group->pluck('name', 'id'),null, ['class' => 'form-control select2', 'required']) !!}
        </div>
        
        <!-- Guard Name Field -->
        <div class="form-group col-sm-2">
            {!! Form::label('guard_name', 'Guard Name:', ['class' => 'd-block']) !!}
            {!! Form::text('guard_name', @$permissions[0]->guard_name, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
<div class="col-sm-6">
    <table class="table table-border" id="table-permission">
        <thead class="thead-dark">
            <tr>
                <th>Action</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if(@$permissions)
                @if(@$permissions->count() > 0)
                    @foreach($permissions as $permission)    
                        <tr id="tr_{{ @$permission->id }}">
                            <td>
                                {!! Form::hidden('id_permission[]', @$permission->id) !!}
                                {!! Form::text('name_permission[]', @$permission->name, ['class' => 'form-control', 'required']) !!}
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-xs btn-icon rem-action" data-id="{{ @$permission->id }}"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <button type="button" class="btn btn-dark btn-xs" id="new-action"><i class="fas fa-plus"></i> New Action</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="clearfix"></div>
<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('permissions.index') !!}" class="btn btn-light">Cancel</a>
</div>

@section('scripts')
<script>
    var row = 0;

    $(document).ready(function()
    {
        $(".select2").select2();;
    });
    
    $(document).on('click', '#new-action', function()
    {
        $("#table-permission tbody").append(`  
            <tr id="tr_new`+row+`">
                <td>
                    {!! Form::hidden('id_permission[]', null) !!}
                    {!! Form::text('name_permission[]', null, ['class' => 'form-control', 'required']) !!}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-xs btn-icon rem-action" data-id="new`+row+`"><i class="fas fa-times"></i></button>
                </td>
            </tr>`);
        row++;
    })

    $(document).on('click', '.rem-action', function()
    {
        let id = $(this).attr('data-id');
        if(confirm('Sure Remove Action Of Permission?')){
            $("#tr_" + id).fadeOut().remove();
        }
    })
</script>
@endsection
