<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:', ['class' => 'd-block']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:', ['class' => 'd-block']) !!}
    {!! Form::file('image', ['class' => 'dropify', 'id' => 'input-file-now', 'data-default-file' => @$ad->image ? asset($ad->image) : '', 'data-allowed-file-extensions' => 'jpg jpeg png', 'data-max-file-size' => '1M']) !!}
</div>

<!-- Location Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_type', 'Location Type:', ['class' => 'd-block']) !!}
    {{-- {!! Form::text('location_type', null, ['class' => 'form-control']) !!} --}}
    <select id="selectType" class="form-control" name="location_type">
        <option value="national" {{ @$ad->location_type == 'national' ? 'selected' : '' }}>Nasional</option>
        <option value="province" {{ @$ad->location_type == 'province' ? 'selected' : '' }}>Provinsi</option>
        <option value="city" {{ @$ad->location_type == 'city' ? 'selected' : '' }}>Kota</option>
    </select>
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6 d-none" id="selectProvince">
    {!! Form::label('province', 'Provinsi: ') !!}
    <select name="province" id="province" class="form-control">
        <option value="" selected disabled>- Pilih Provinsi -</option>
        @foreach ($province as $item)
            <option value="{{ $item->id }}" {{ @$ad->location_type == 'province' ? 'selected' : '' }}>{{ $item->province_name }}</option>
        @endforeach
    </select>
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6 d-none" id="selectCity">
    {!! Form::label('city', 'Kota: ') !!}
    <select name="city" id="location_id" class="form-control">
        <option value="" selected disabled>- Pilih Kota -</option>
    </select>
</div>

<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-6">
            {!! Form::label('date_start', 'Date start: ') !!}
            {!! Form::input('dateTime-local','date_start', @$ad->date_start, ['class' => 'form-control date']) !!}
        </div>
        <div class="col-6">
            {!! Form::label('date_end', 'Date end: ') !!}
            {!! Form::input('dateTime-local','date_end', @$ad->date_end, ['class' => 'form-control date']) !!}
        </div>
    </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('link', 'Link: ') !!}
    <input type="text" name="link" class="form-control" value="{{ @$ad->link }}" id="">
</div>

<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status: ') !!}
    <select name="status" id="status" class="form-control">
        <option value="draft" {{ @$ad->status == null || @$ad->status == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="publish" {{ @$ad->status == 'publish' ? 'selected' : '' }}>Publish</option>
    </select>
</div>

<div class="clearfix"></div>
<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ads.index') !!}" class="btn btn-light">Cancel</a>
</div>

@section('scripts')
<!-- Relational Form table -->
<script>
$(document).ready(function() {
    var city = @json($city);
    var province = @json($province);
    var data = @json(@$ad);
    if (data?.location_type == 'province') {
        $('#selectProvince').removeClass('d-none');
    } else if (data?.location_type == 'city') {
        var selectedCity = city.filter(item => item.id == data.location_id);
        var selectedProvince = province.filter(item => item.id == selectedCity[0].province_code);
        $('#selectProvince').removeClass('d-none');
        $('#selectCity').removeClass('d-none');
        $('#province').empty();
        $('#city').empty();
        province.forEach(item => {
            $('#province').append(`
                <option value="${item.id}" ${item.id == selectedProvince[0].id ? 'selected' : ''}>${item.province_name}</option>
            `)
        });
        city.forEach(item => {
            $('#location_id').append(`
                <option value="${item.id}" ${item.id == data.location_id ? 'selected' : ''}>${item.city_name}</option>
            `)
        });
    }
    $('#selectType').on('change', function() {
        if ($(this).val() == 'national') {
            $('#selectProvince').addClass('d-none');
            $('#selectCity').addClass('d-none');
        } else {
            $('#selectProvince').removeClass('d-none');
        }
    })
    $('#province').on('change', function() {
        var provinceId = $(this).val();

        if ($('#selectType').val() != 'province') {
            var selectCity = $('#selectCity');
            var data = city.filter(item => item.province_code == provinceId)
            var selectCityComponent = $('#location_id')
            selectCity.removeClass('d-none');
            selectCityComponent.empty();
            data.forEach(item => {
                selectCityComponent.append('<option class="option-text" value="'+item.id+'">'+item.city_name+'</option>');
            });
        }
    })
    $('.dropify').dropify({
        messages: {
            default: 'Drag and drop file here or click',
            replace: 'Drag and drop file here or click to Replace',
            remove:  'Remove',
            error:   'Sorry, the file is too large'
        }
    });
    var editor_config = {
            path_absolute : "/",
            selector: 'textarea.my-editor2',
            height : "250",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            menubar: false,
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                    cmsURL = cmsURL + "&type=Files";

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        }
        tinymce.init(editor_config);
    });
    $('.btn-add-related').on('click', function() {
        var relation = $(this).data('relation');
        var index = $(this).parents('.panel').find('tbody tr').length - 1;

        if($('.empty-data').length) {
            $('.empty-data').hide();
        }

        // TODO: edit these related input fields (input type, option and default value)
        var inputForm = '';
        var fields = $(this).data('fields').split(',');
        // $.each(fields, function(idx, field) {
        //     inputForm += `
        //         <td class="form-group">
        //             {!! Form::select('`+relation+`[`+relation+index+`][`+field+`]', [], null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
        //         </td>
        //     `;
        // })
        $.each(fields, function(idx, field) {
            inputForm += `
                <td class="form-group">
                    {!! Form::text('`+relation+`[`+relation+index+`][`+field+`]', null, ['class' => 'form-control', 'style' => 'width:100%']) !!}
                </td>
            `;
        })

        var relatedForm = `
            <tr id="`+relation+index+`">
                `+inputForm+`
                <td class="form-group" style="text-align:right">
                    <button type="button" class="btn-delete btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                </td>
            </tr>
        `;

        $(this).parents('.panel').find('tbody').append(relatedForm);

        $('#'+relation+index+' .select2').select2();
    });

    $(document).on('click', '.btn-delete', function() {
        var actionDelete = confirm('Are you sure?');
        if(actionDelete) {
            var dom;
            var id = $(this).data('id');
            var relation = $(this).data('relation');

            if(id) {
                dom = `<input class="`+relation+`-delete" type="hidden" name="`+relation+`-delete[]" value="` + id + `">`;
                $(this).parents('.box-body').append(dom);
            }

            $(this).parents('tr').remove();

            if(!$('tbody tr').length) {
                $('.empty-data').show();
            }
        }
    });
</script>
<!-- End Relational Form table -->
@endsection
