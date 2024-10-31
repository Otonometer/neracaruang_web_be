<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-items" role="presentation">
        <a class="nav-link active" id="base-tab" data-toggle="tab" href="#base" type="button" role="tab"
            aria-controls="content" aria-selected="true">Content</a>
    </li>
    @ismediacontent($typeId)
        <li class="nav-items" role="presentation">
            <a class="nav-link" id="image-tab" data-toggle="tab" href="#images" type="button" role="tab"
                aria-controls="images" aria-selected="true">Images</a>
        </li>
    @endismediacontent
</ul>

<input type="hidden" value="{{ $typeId }}" name="type_id">
<div class="tab-content pt-3" id="myTabContent">
    <div class="tab-pane fade active show" id="base" role="tabpanel" aria-labelledby="base-tab">
        <div class="form-group col-sm-6">
            {!! Form::label('title', 'Title:', ['class' => 'd-block']) !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        @unlessismediacontent($typeId)
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('summary', 'Summary:', ['class' => 'd-block']) !!}
                {!! Form::textarea('summary', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('content', 'Content:', ['class' => 'd-block']) !!}
                {!! Form::textarea('content', null, ['class' => 'form-control my-editor']) !!}
            </div>
        @endismediacontent

        <div class="row col-sm-12">
            @foreach ($subjectTypes as $subject => $tags)
                <div class="form-group col-sm-4">
                    <label for="">{{ ucwords($subjectTypesEnum::tryFrom($subject)->title()) }}</label>
                    <select name="tags[]" class="form-control select2">
                        <option value="">Select {{ ucwords($subjectTypesEnum::tryFrom($subject)->title()) }}
                        </option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ isset($content) && isset($content->tags[$subject]) && $content->tags[$subject] === $tag->id ? 'selected' : '' }}>
                                {{ $tag->title }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>

        <div class="row col-sm-12 align-items-center">
            <div class="form-group col-sm-4">
                <label for="writer">Writer:</label>
                <select name="created_by" id="" class="form-control select2">
                    @foreach ($writers as $writer)
                        <option value="{{ $writer->id }}"
                            {{ isset($content) && $content->created_by == $writer->id ? 'selected' : '' }}>
                            {{ $writer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#writerModal">Add
                    Writer</button>
            </div>
        </div>

        @if ($typeId === $contentTypesEnum::VIDEO->value)
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('video', 'Video:', ['class' => 'd-block']) !!}
                {!! Form::text('video', null, ['class' => 'form-control']) !!}
            </div>
        @endif
        <div class="row col-sm-12">
            <div class="form-group col-sm-6">
                {!! Form::label('location_type', 'Location Type:') !!}
                <select name="location_type" class="select2 form-control">
                    @foreach ($locationTypesEnum::cases() as $type)
                        <option value="{{ $type->value }}"
                            {{ isset($content) && $content?->location_type === $type->value ? 'selected' : '' }}>
                            {{ \Str::ucfirst($type->value) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6 {{ isset($content) && $content?->location_type === $locationTypesEnum::NATIONAL->value ? 'd-none' : '' }}"
                id="location_id_field">
                {!! Form::label('location_id', 'Location:') !!}
                <select name="location_id" class="select2 form-control">
                    @foreach ($provinces as $province)
                        @if (isset($content) && $content?->location_type === $locationTypesEnum::CITY->value)
                            @foreach ($province->cities as $city)
                                <option value="{{ $city->id }}"
                                    {{ isset($content) && $content?->location_id === $city->id ? 'selected' : '' }}>
                                    {{ $city->city_name }}</option>
                            @endforeach
                        @endif
                        <option value="{{ $province->id }}"
                            {{ isset($content) && $content?->location_id === $province->id ? 'selected' : '' }}>
                            {{ $province->province_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @unlessismediacontent($typeId)
            <div class="row align-items-center col-sm-12">
                {!! Form::label('image', 'Thumbnail:', ['class' => 'col-sm-6']) !!}
            </div>
            <div class="form-group col-sm-6">
                <input type="file" class="dropify" name="image"
                    data-default-file="{{ isset($content) ? asset($content->image) : '' }}"
                    data-allow-extension='jpg jpeg png' {{ !isset($content) ? 'required' : '' }}>
            </div>
            @endismediacontent($typeId)

            <div class="form-group col-sm-12">
                <div class="row">
                    <div class="col-6">
                        {!! Form::label('publish_date', 'Publish date:', ['class' => 'd-block']) !!}
                        {!! Form::input('dateTime-local', 'publish_date', @$content->publish_date, ['class' => 'form-control date']) !!}
                    </div>
                    <div class="col-6">
                        {!! Form::label('status', 'Status:', ['class' => 'd-block']) !!}
                        <select name="status" id="" class="form-control">
                            <option value="publish" {{ @$content->status == 'publish' ? 'selected' : '' }}>Publish</option>
                            <option value="draft" {{ @$content->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archive" {{ @$content->status == 'archive' ? 'selected' : '' }}>Archive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @ismediacontent($typeId)
        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
            <div id="images-field">
                <div class="row align-items-center col-sm-12 mb-3">
                    {!! Form::label('image', 'Images:', ['class' => 'col-sm-6']) !!}
                    <div class="ml-auto">
                        <button class="btn btn-primary" type="button" id="btn-add-image">Add Image</button>
                    </div>
                </div>
                <div class="form-group col-sm-6" id="content-media-group">
                    @if ($errors->has('medias.*.image') || $errors->has('medias.*.summary'))
                        @foreach (old('medias', []) as $media)
                            <div class="mb-3">
                                <input type="file" class="dropify" name={{ "medias[$loop->index][image]" }}>
                                <div class="input-group mg-b-10">
                                    <div class="input-group-prepend">
                                        <input type="text" class="form-control mt-3"
                                            name={{ "medias[$loop->index][cms_document_label]" }} value="Dokumentasi Oleh"
                                            placeholder="Label">
                                    </div>
                                    <input type="text" class="form-control mt-3"
                                        name={{ "medias[$loop->index][cms_document_value]" }} placeholder="Value"
                                        value={{ old('medias.' . $loop->index . '.cms_document_value') }}>
                                </div>
                                <input type="text" class="form-control mt-3"
                                    name={{ "medias[$loop->index][documented_by]" }} placeholder="Documented By"
                                    value={{ old('medias.' . $loop->index . '.documented_by') }}>
                                <textarea class="form-control mt-3" name={{ "medias[$loop->index][summary]" }}>{{ old('medias.' . $loop->index . '.summary') }}</textarea>
                            </div>
                        @endforeach
                    @else
                        @isset($content)
                            @foreach ($content->medias as $index => $media)
                                <div class="mb-3">
                                    @if ($index !== 0)
                                        <button type="button" class="btn btn-danger mb-3 remove-image"
                                            data-media-id="{{ $media->id }}">Remove</button>
                                    @endif
                                    <input type="hidden" name={{ "medias[$index][id]" }} value="{{ $media->id }}">
                                    <input type="file" class="dropify" name={{ "medias[$index][image]" }}
                                        data-default-file="{{ asset($media->image) }}" data-allow-extension="jpeg jpg png">
                                    <div class="input-group mg-b-10">
                                        <div class="input-group-prepend">
                                            <input type="text" class="form-control mt-3"
                                                name={{ "medias[$index][cms_document_label]" }}
                                                value="{{ !empty(@$media->cms_document_label) ? @$media->cms_document_label : 'Dokumentasi Oleh' }}"
                                                placeholder="Label">
                                        </div>
                                        <input type="text" class="form-control mt-3"
                                            name={{ "medias[$index][cms_document_value]" }}
                                            value="{{ @$media->cms_document_value }}" placeholder="Value">
                                    </div>
                                    <textarea class="form-control mt-3" name={{ "medias[$index][summary]" }}>{{ $media->summary }}</textarea>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-3">
                                <input type="file" class="dropify" name="medias[0][image]">
                                <div class="input-group mg-b-10">
                                    <div class="input-group-prepend">
                                        <input type="text" class="form-control mt-3" name="medias[0][cms_document_label]"
                                            value="Dokumentasi Oleh" placeholder="Label">
                                    </div>
                                    <input type="text" class="form-control mt-3" name="medias[0][cms_document_value]"
                                        placeholder="Value">
                                </div>
                                <input type="text" class="form-control mt-3" name="medias[0][documented_by]"
                                    placeholder="Documented By">
                                <textarea class="form-control mt-3" name="medias[0][summary]"></textarea>
                            </div>
                        @endisset
                    @endif

                </div>
            </div>
        </div>
    @endismediacontent
</div>

<div class="clearfix"></div>
<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('contents.index', $contentTypesEnum::tryFrom($typeId)->slug()) !!}" class="btn btn-light">Cancel</a>
</div>

@include('contents.modal_writer')
@section('scripts')
    <!-- Relational Form table -->
    <script>
        $(document).ready(function() {
            $('.select2').select2()
            $('.dropify').dropify({
                messages: {
                    default: 'Drag and drop file here or click',
                    replace: 'Drag and drop file here or click to Replace',
                    remove: 'Remove',
                    error: 'Sorry, the file is too large'
                }
            });
            var editor_config = {
                path_absolute: "/",
                selector: 'textarea.my-editor2',
                height: "250",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                menubar: false,
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                relative_urls: false,
                file_browser_callback: function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document
                        .getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document
                        .getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                    cmsURL = cmsURL + "&type=Files";

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no"
                    });
                }
            }
            tinymce.init(editor_config);
        });
        $('.btn-add-related').on('click', function() {
            var relation = $(this).data('relation');
            var index = $(this).parents('.panel').find('tbody tr').length - 1;

            if ($('.empty-data').length) {
                $('.empty-data').hide();
            }

            // TODO: edit these related input fields (input type, option and default value)
            var inputForm = '';
            var fields = $(this).data('fields').split(',');
            $.each(fields, function(idx, field) {
                inputForm += `
                <td class="form-group">
                    {!! Form::select('`+relation+`[`+relation+index+`][`+field+`]', [], null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                    ]) !!}
                 </td>
             `;
            })
            $.each(fields, function(idx, field) {
                inputForm += `
                <td class="form-group">
                    {!! Form::text('`+relation+`[`+relation+index+`][`+field+`]', null, [
                        'class' => 'form-control',
                        'style' => 'width:100%',
                    ]) !!}
                </td>
            `;
            })

            var relatedForm = `
            <tr id="` + relation + index + `">
                ` + inputForm + `
                <td class="form-group" style="text-align:right">
                    <button type="button" class="btn-delete btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                </td>
            </tr>
        `;

            $(this).parents('.panel').find('tbody').append(relatedForm);

            $('#' + relation + index + ' .select2').select2();
        });

        $(document).on('click', '.btn-delete', function() {
            var actionDelete = confirm('Are you sure?');
            if (actionDelete) {
                var dom;
                var id = $(this).data('id');
                var relation = $(this).data('relation');

                if (id) {
                    dom = `<input class="` + relation + `-delete" type="hidden" name="` + relation +
                        `-delete[]" value="` + id + `">`;
                    $(this).parents('.box-body').append(dom);
                }

                $(this).parents('tr').remove();

                if (!$('tbody tr').length) {
                    $('.empty-data').show();
                }
            }

        });

        const province = @json($provinces);
        $(document).on('select2:select', 'select[name="location_type"]', (e) => {
            const selected = $(e.target).find(':selected').val()

            $('#location_id_field').removeClass('d-none')
            $('select[name="location_id"]').children().remove()

            if (selected === 'province') {
                $('select[name="location_id"]').append(`
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ isset($content) && $content?->location_id === $province->id ? 'selected' : '' }}>{{ $province->province_name }}</option>
                    @endforeach
             `)
            }

            if (selected === 'city') {
                $('select[name="location_id"]').append(`
                    @foreach ($provinces as $province)
                        @foreach ($province->cities as $city)
                            <option value="{{ $city->id }}" {{ isset($content) && $content?->location_id === $city->id ? 'selected' : '' }}>{{ $city->city_name }}</option>
                        @endforeach
                    @endforeach
             `)
            }

            if (selected === 'national') {
                $('#location_id_field').addClass('d-none')
            }
        })

        $(document).on('click', '#btn-add-image', (e) => {
            const mediaLength = $('#content-media-group').children().length

            $('#content-media-group').append(`
            <div class="mb-3">
                <button type="button" class="btn btn-danger mb-3 remove-image">Remove</button>
                <input type="file" class="dropify" name="medias[${mediaLength}][image]" required>
                <div class="input-group mg-b-10">
                    <div class="input-group-prepend">
                        <input type="text" class="form-control mt-3" name="medias[${mediaLength}][cms_document_label]"
                            value="Dokumentasi Oleh" placeholder="Label">
                    </div>
                    <input type="text" class="form-control mt-3" name="medias[${mediaLength}][cms_document_value]"
                        placeholder="Value">
                </div>
                <input type="text" class="form-control mt-3" name="medias[${mediaLength}][documented_by]"
                    placeholder="Documented By">
                <textarea class="form-control mt-3" name="medias[${mediaLength}][summary]" required></textarea>
            </div>
        `)
            $('.dropify').dropify({
                messages: {
                    default: 'Drag and drop file here or click',
                    replace: 'Drag and drop file here or click to Replace',
                    remove: 'Remove',
                    error: 'Sorry, the file is too large'
                }
            });
        })

        $(document).on('click', '.remove-image', (e) => {
            const mediaId = $(e.target).attr('data-media-id')
            if (mediaId) {
                $.ajax({
                    method: 'DELETE',
                    url: `/content-media/${mediaId}`,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: (resp) => console.log(resp),
                    error: (err) => console.log(err)
                })
            }

            $(e.target).parent().remove()
        })

        $(document).on('click', '#btnSubmitWriter', function(e) {
            $.ajax({
                method: 'POST',
                url: "/writer",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: $('input[name="writer-name"]').val()
                },
                success: (resp) => {
                    $('select[name="created_by"]').append(`
                    <option value=${resp.data.id} >${resp.data.name}</option>
                `)
                    alert(resp.message)
                    $('#writerModal').modal('hide')
                },
                error: (err) => {
                    if (err.status === 422) {
                        const json = err.responseJSON
                        $('#errorName').remove()
                        $('input[name="writer-name"]').after(`
                        <span class='text-danger' id="errorName">${json.errors.name[0]}</span>
                    `)
                    }
                }
            })
        })
    </script>
    <!-- End Relational Form table -->
@endsection
