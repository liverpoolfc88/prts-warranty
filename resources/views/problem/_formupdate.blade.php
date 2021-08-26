<div class="form-group {{ $errors->has('department_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('department_id', trans('app.problem.department_id'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('department_id', \App\Department::pluck('name','id'), $model->department_id, ['class' => 'form-control']) !!}
        {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('part_type') ? 'has-error' : ''}}">
    {!! Form::label('part_type', trans('app.problem.part_type'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('part_type', $model->part_type, ['class' => 'form-control']) !!}
        {!! $errors->first('part_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--check sheet--}}

<div class="form-group" >
    <label class="col-sm-3 control-label">{{ trans('app.level1.name')}}</label>
    <div class="col-sm-6">
        <select id="level_first_id" value="<?=(!empty($model->level_second->level->id)) ? $model->level_second->level->id : ''?>"  name="level_first_id" required class=" change form-control">
            <option value="<?=(!empty($model->level_second->level->id)) ? $model->level_second->level->id :''?>"><?=(!empty($model->level_second->level->name)) ? $model->level_second->level->name : ''?></option>
            <? foreach (\App\Level_first::all() as $key =>$val){?>
            <option value="<?=$val->id?>"><?=$val->name.'-'.$val->id?></option>
            <? } ?>
        </select>
    </div>

</div>


<div class="form-group {{ $errors->has('level_second_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('level_second_id',trans('app.level2.name'), ['class' => 'col-sm-3 control-label', 'required' => 'required']) !!}
    <div class="col-sm-6">
        <select  required id="levelsecond" name="level_second_id" class="form-control">
            <option value="<?=(empty($model->level_second->id)) ? '' : $model->level_second->id?>"><?=(empty($model->level_second->name)) ? '' : $model->level_second->name?></option>
        </select>
    </div>
</div>



<div class="form-group {{ $errors->has('fault_type_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('fault_type_id', trans('app.problem.fault_type'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('fault_type_id', \App\Fault_type::pluck('name','id'), $model->fault_type_id, ['class' => 'form-control','placeholder' => 'Типы дефеков']) !!}
        {!! $errors->first('fault_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


{{--check sheet--}}

<div class="form-group {{ $errors->has('dealer_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('dealer_id', trans('app.dealer.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('dealer_id', \App\Dealer::pluck('name','id'), $model->dealer_id, ['class' => 'form-control']) !!}
        {!! $errors->first('dealer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('region_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('region_id', trans('app.region.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('region_id', \App\Region::pluck('name','id'), $model->region_id, ['class' => 'form-control']) !!}
        {!! $errors->first('region_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('vehicle_model_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('vehicle_model_id', trans('app.vehicleModel.name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('vehicle_model_id', \App\VehicleModel::pluck('name','id'), $model->vehicle_model_id, ['class' => 'form-control']) !!}
        {!! $errors->first('vehicle_model_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('vin') ? 'has-error' : ''}}">
    {!! Form::label('vin', trans('app.problem.vin'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('vin', $model->vin, ['class' => 'form-control']) !!}
        {!! $errors->first('vin', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{{--kalendar--}}
<div class="form-group {{ $errors->has('created_at') ? 'has-error' : ''}}">
    {!! Form::label('created_at', trans('Дата'), [ 'class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('created_at', $model->created_at, ['id'=>'date','class' => 'form-control datepicker']) !!}
        {!! $errors->first('created_at', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', trans('app.problem.description'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', $model->description, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--<div class="form-group {{ $errors->has('contact_info') ? 'has-error' : ''}}">--}}
{{--    {!! Form::label('contact_info', trans('app.problem.contact_info'), ['class' => 'col-sm-3 control-label']) !!}--}}
{{--    <div class="col-sm-6">--}}
{{--        {!! Form::text('contact_info', $model->contact_info, ['class' => 'form-control']) !!}--}}
{{--        {!! $errors->first('contact_info', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group {{ $errors->has('problem_type_id') ? 'has-error' : ''}}"
     style="display: {{ $model->role == \App\User::ROLE_SUPPLIER ? 'none' : 'block' }}">
    {!! Form::label('problem_type_id', trans('app.problem.problem_type_id'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('problem_type_id', \App\ProblemType::pluck('name','id'), $model->problem_type_id, ['class' => 'form-control']) !!}
        {!! $errors->first('problem_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(function () {
        var m_id = <?=(!empty($model->level_second->id)) ? $model->level_second->id : 0?>;
        var m_name = '<?=(!empty($model->level_second->name)) ? $model->level_second->name : ''?>';

        // alert(m_name);

        // $('select#levelsecond').append('<option value="m_id">m_name</option>');
        $(document).on('change','.change',function () {

            var id = $(this).val();
            console.log(id);
            $.ajax({
                type:'get',
                url: '{!! Url::to('levelsecond') !!}',
                data:{id:id},
                success:function (data) {
                    $('select#levelsecond')
                        .find('option')
                        .remove()
                        .end()
                    ;
                    $.each(data, function(key, value){
                        $('select#levelsecond').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                },
                error:function () {
                    console.log(error);
                }
            });

        });
    })
</script>

<script>
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
    });

</script>