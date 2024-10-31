<div class="col-sm-12">
    <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('name', 'Name:', ['class' => 'd-block']) !!}
                <p class="tx-bold">{!! $writer->name !!}</p>
            </div>
            <!-- Name Field -->
    </div>
</div>


<div class="clearfix"></div>
<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('writer.index') !!}" class="btn btn-light">Cancel</a>
</div>
