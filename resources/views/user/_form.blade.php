<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('app.user.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', trans('app.user.email'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::email('email', $model->email, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    {!! Form::label('phone_number', trans('app.user.phone_number'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('phone_number', $model->phone_number, ['class' => 'form-control']) !!}
        {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    {!! Form::label('role', trans('app.user.role'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('role', [\App\User::ROLE_EMPLOYEE=>trans('app.user.role_0'),\App\User::ROLE_SUPPLIER=>trans('app.user.role_1')], $model->role, ['class' => 'form-control']) !!}
        {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}}" style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('role_id', trans('app.user.role_id'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('role_id', $roles, count($model->roles)>0 ? $model->roles[0]->id : null, ['class' => 'form-control']) !!}
        {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('department_id') ? 'has-error' : ''}}" style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'block' : 'none' }}">
    {!! Form::label('department_id', trans('app.problem.department_id'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('department_id', $departments, count($model->departments)>0 ? $model->departments[0]->id : null, ['class' => 'form-control']) !!}
        {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('password', trans('app.user.password'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::password('password', ['class' => 'form-control']) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>


@section('scripts')
    $('#role').on('change', function(e){
        if(this.value == 1 ) {
            $('#role_id').closest('div.form-group').hide();
            $('#department_id').closest('div.form-group').show();
        }
        else {
            $('#role_id').closest('div.form-group').show();
            $('#department_id').closest('div.form-group').hide();
        }
    });
@endsection

