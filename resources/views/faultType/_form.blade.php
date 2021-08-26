<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.fault_type.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('kod') ? 'has-error' : ''}}">
    {!! Form::label('kod', trans('app.fault_type.kod'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('kod', $model->email, ['class' => 'form-control']) !!}
        {!! $errors->first('kod', '<p class="help-block">:message</p>') !!}
    </div>
</div>

