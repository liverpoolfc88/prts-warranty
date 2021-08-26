<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.dealer.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address', trans('app.dealer.address'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('address', $model->address, ['class' => 'form-control']) !!}
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
    {!! Form::label('contact', trans('app.dealer.contact'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('contact', $model->contact, ['class' => 'form-control']) !!}
        {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
    </div>
</div>

