
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.department.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}<br>
        {!! Form::text('manager', $model->manager, ['class' => 'form-control']) !!}<br>
        {!! Form::text('email', $model->email, ['class' => 'form-control']) !!}<br>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>