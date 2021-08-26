<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', trans('app.stage.title'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('title', $model->title, ['class' => 'form-control']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('sequence') ? 'has-error' : ''}}">
    {!! Form::label('sequence', trans('app.stage.sequence'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::number('sequence', $model->sequence, ['class' => 'form-control']) !!}
        {!! $errors->first('sequence', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('stage_group_id') ? 'has-error' : ''}}">
    {!! Form::label('stage_group_id', trans('app.stageGroup.title'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('stage_group_id', \App\StageGroup::all()->pluck('title', 'id'), $model->stage_group_id, ['class' => 'form-control']) !!}
        {!! $errors->first('stage_group_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('has_action') ? 'has-error' : ''}}">
    {!! Form::label('has_action', trans('app.stage.has_action'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::checkbox('has_action', null, $model->has_action, ['class' => 'checkbox']) !!}
        {!! $errors->first('has_action', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('has_date') ? 'has-error' : ''}}">
    {!! Form::label('has_date', trans('app.stage.has_date'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::checkbox('has_date', null, $model->has_date, ['class' => 'checkbox']) !!}
        {!! $errors->first('has_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('has_attachment') ? 'has-error' : ''}}">
    {!! Form::label('has_attachment', trans('app.stage.has_attachment'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::checkbox('has_attachment', null, $model->has_attachment, ['class' => 'checkbox']) !!}
        {!! $errors->first('has_attachment', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('has_approval') ? 'has-error' : ''}}">
    {!! Form::label('has_approval', trans('app.stage.has_approval'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::checkbox('has_approval', null, $model->has_approval, ['class' => 'checkbox']) !!}
        {!! $errors->first('has_approval', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('owner') ? 'has-error' : ''}}">
    {!! Form::label('owner', trans('app.stage.owner'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('owner', [\App\User::ROLE_EMPLOYEE => trans('app.user.role_0'), \App\User::ROLE_SUPPLIER => trans('app.user.role_1')], $model->owner, ['class' => 'form-control']) !!}
        {!! $errors->first('owner', '<p class="help-block">:message</p>') !!}
    </div>
</div>
