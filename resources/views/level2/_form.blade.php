<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.level2.level_first_id'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
{{--        {!! Form::text('level_first_id', $model->level_first_id, ['class' => 'form-control']) !!}--}}
        {!! Form::select('level_first_id', \App\Level_first::pluck('name','id'), $model->level_first_id, ['class' => 'form-control','placeholder' => trans('app.level2.level_first_id')]) !!}
        {!! $errors->first('level_first_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.level2.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>


