<div class="col-sm-12">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('name', 'Name:', ['class' => 'd-block']) !!}
            <p class="tx-bold">{!! $role->name !!}</p>
        </div>
        
        <!-- Guard Name Field -->
        <div class="form-group col-sm-2">
            {!! Form::label('guard_name', 'Guard Name:', ['class' => 'd-block']) !!}
            <p class="tx-bold">{!! $role->guard_name !!}</p>
        </div>
    </div>
</div>

<div class="px-3 wd-50p">
    @foreach ($permissions as $permission)
        <div class="d-flex justify-content-between align-items-center bg-secondary rounded pl-3 py-2 mb-2 text-white">
            <span class="tx-bold">{{ $permission['group'] }}</span>
        </div>
        <div class="mb-3">
            @foreach ($permission['labels'] as $label)
            <div class="mb-4 p-2 border rounded group-categories">
                <div class="d-flex justify-content-between mb-2">
                    <p class="tx-bold">{{ $label['name'] }}</p>
                </div>
                <div class="row px-3 d-block group-permission">
                    @foreach ($label['permissions'] as $access)
                        @if(!empty(@$role))
                            @if(@$role->hasPermissionTo(@$access->name))
                                <p class="pd-3">{{ ucfirst($access->name) }}</p>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
</div>