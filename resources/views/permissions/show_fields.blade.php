<div class="col-sm-12">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('name', 'Name:', ['class' => 'd-block tx-bold']) !!}
            <p>{!! $label->name !!}</p>
        </div>

        <!-- Group Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('permission_group_id', 'Group:', ['class' => 'd-block tx-bold']) !!}
            <p>{!! $group->name !!}</p>
        </div>
        
        <!-- Guard Name Field -->
        <div class="form-group col-sm-2">
            {!! Form::label('guard_name', 'Guard Name:', ['class' => 'd-block tx-bold']) !!}
            <p>{!! @$permissions[0]->guard_name !!}</p>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <table class="table table-border" id="table-permission">
        <thead class="thead-dark">
            <tr>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(@$permissions)
                @if(@$permissions->count() > 0)
                    @foreach($permissions as $permission)    
                        <tr id="tr_{{ @$permission->id }}">
                            <td>{{ @$permission->name }}</td>
                        </tr>
                    @endforeach
                @endif
            @endif
        </tbody>
    </table>
</div>

