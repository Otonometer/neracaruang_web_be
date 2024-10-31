<div class="col-sm-12">
    <div class="row">
            {!! Form::hidden('id', @$user->id, ['class' => 'form-control']) !!}
            <!-- Name Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('name', 'Name:', ['class' => 'd-block']) !!}
                <p class="tx-bold">{!! $user->name !!}</p>
            </div>
            <!-- Name Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('email', 'Email:', ['class' => 'd-block']) !!}
                <p class="tx-bold">{!! $user->email !!}</p>
            </div>
    </div>
</div>

<div class="px-3">
    @foreach ($permissions as $permission)
        <div class="d-flex justify-content-between align-items-center bg-secondary rounded pl-3 py-2 mb-2 text-white">
            <span class="tx-bold">{{ $permission['group'] }}</span>
            <button class="btn text-white btn-hide" type="button">Hide <i class="icon ion-md-arrow-up mg-l-5"></i></button>
        </div>
        <div class="mb-3">
            @foreach ($permission['labels'] as $label)
            <div class="mb-4 p-2 border rounded group-categories">
                <div class="d-flex justify-content-between mb-2">
                    <p class="tx-bold">{{ $label['name'] }}</p>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input check-all">
                        <label class="custom-control-label tx-bold lebel-check-all">Check All</label>
                    </div>
                </div>
                <div class="row px-3 group-permission">
                    @foreach ($label['permissions'] as $access)
                    <div class="col-md-3 custom-control custom-checkbox">
                        {{Form::checkbox('',  $access->id, !empty(@$user) ? (@$user->hasPermissionTo(@$access->name) ? 'checked' : null) : null, ['class' => 'custom-control-input check-permission'] ) }}
                        {{Form::label('', ucfirst($access->name), ['class' => 'custom-control-label label-check-permission']) }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
</div>

<div class="clearfix"></div>
<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-light">Cancel</a>
</div>

@section('scripts')
<script>

    let checkedList = []
    $(document).ready(() => {
        const categories = $('.check-all')
        const permissions = $('.check-permission')

        $.each(categories,(i,category) => {
            let name = `all-${i + 1}`
            $('.check-all').eq(i).attr({'name' : name,'id' : name})
            $('.lebel-check-all').eq(i).attr('for',name)
            $('.group-permission').eq(i).attr('data-idx-category',i + 1)

            const permission = $(`[data-idx-category='${i+1}']`)[0]
            const input_permission = permission.querySelectorAll('input')

            if (input_permission.length === [...input_permission].filter((input) => input.checked === true).length) {
                categories[i].checked = true
                checkedList.push(i + 1)
            }
        })

        $.each(permissions,(i,permission) => {
            let name = `permission-${i+1}`
            $('.check-permission').eq(i).attr({'name' : `permissions[${i+1}]`,'id':name})
            $('.label-check-permission').eq(i).attr('for',name)
        })
    })

    $(document).on('change','.check-all',(e) => {
        const id = parseInt(e.target.id.substring(4))

        const permission = $(`[data-idx-category='${id}']`)[0]
        const input_permission = permission.querySelectorAll('input')

        if (checkedList.includes(id)) {
            $.each(input_permission,(i,input) => {
                input_permission[i].checked = false  
            })

            checkedList = checkedList.filter((list) => list !== id)
        }else{
            $.each(input_permission,(i,input) => {
                input_permission[i].checked = true  
            })

            checkedList.push(id)
        }
    })

    $(document).on('change','.check-permission',(e) => {
        const category = $(e.target).parent().parent()[0]
        const input_permission = category.querySelectorAll('input')
        const idx = parseInt(category.dataset.idxCategory)
        const check_all = document.getElementById(`all-${idx}`)

        if(checkedList.includes(idx)){
            check_all.checked = false
            checkedList = checkedList.filter((list) => list !== idx)
            return
        }

        if (input_permission.length === [...input_permission].filter((input) => input.checked === true).length) {
            check_all.checked = true
            checkedList.push(idx)
        }
        
    })

    $(document).on('click', '.btn-hide' , (e) => {
        const row_categories = e.target.parentElement.nextElementSibling

        if ([...row_categories.classList].includes('d-none')) {
            row_categories.classList.remove('d-none')
            e.target.innerHTML = 'Hide <i class="icon ion-md-arrow-up mg-l-5"></i>'
            return
        }

        row_categories.classList.add('d-none')
        e.target.innerHTML = 'Show <i class="icon ion-md-arrow-down mg-l-5"></i>'
    })
</script>
@endsection
