<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.vehicleModel.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('responsible_email') ? 'has-error' : ''}}">
    {!! Form::label('responsible_email', trans('app.vehicleModel.responsibleEmail'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('responsible_email', $model->responsible_email, ['class' => 'form-control']) !!}
        {!! $errors->first('responsible_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

