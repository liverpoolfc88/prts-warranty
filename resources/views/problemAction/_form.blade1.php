<?php
/**
 * Created by PhpStorm.
 * User: MSherali
 * Date: 26.12.2017
 * Time: 11:19
 */
?>
<div class="panel-body">
    {!! Form::model($model, [
        'method' => 'PATCH',
        'id' =>'form-problem-action',
        'url' => ['/problem-action', $pendingProblemAction->id],
        'class' => 'form-horizontal',
        'enctype'=>'multipart/form-data'
    ]) !!}
    @if($pendingProblemAction->stage->has_action)
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            {!! Form::label('content', $pendingProblemAction->stage->has_approval ? trans('app.problemActions.comment') : trans('app.problemActions.content'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::textarea('content', $pendingProblemAction->content, ['class' => 'form-control']) !!}
                {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    @endif
    @if($pendingProblemAction->stage->has_attachment)
        <div class="form-group {{ $errors->has('attachment') ? 'has-error' : ''}}">
            {!! Form::label('attachment', trans('app.problemActions.attachment'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
                @if($model->current_stage_id == 4)
                    {!! Form::file('attachment', $pendingProblemAction->attachment, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('attachment', '<p class="help-block">:message</p>') !!}
                @else 
                    {!! Form::file('attachment', $pendingProblemAction->attachment, ['class' => 'form-control']) !!}
                    {!! $errors->first('attachment', '<p class="help-block">:message</p>') !!}
                @endif
            </div>
        </div>
    @endif
    @if($pendingProblemAction->stage->has_date)
        <div class="form-group {{ $errors->has('deadline_at') ? 'has-error' : ''}}">
            {!! Form::label('deadline_at', trans('app.problemActions.deadline_at'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('deadline_at', $pendingProblemAction->attachment, ['class' => 'form-control datepicker']) !!}
                {!! $errors->first('deadline_at', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    @endif

    @if($pendingProblemAction->stage->has_approval)
        <div class="form-group {{ $errors->has('accepted') ? 'has-error' : ''}}">
            <div class="col-sm-6 text-right">
                {!! Form::checkbox('accepted', 1,null, ['class' => 'form-control bootstrap-switch']) !!}
                {!! $errors->first('accepted', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-6 text-left">
                {!! Form::button( trans('app.btn.save'), ['type' => 'submit', 'class' => 'btn btn-primary btn-md']) !!}
            </div>
        </div>
        <input id="not_accepted" type="hidden" value="1" name="not_accepted" />
    @else
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8 text-right">
                {!! Form::button( trans('app.btn.save'), ['type' => 'submit', 'class' => 'btn btn-primary btn-md']) !!}
                <a href="{{ url('problem', $model->id) }}" class="btn btn-md btn-default">{!! trans('app.btn.cancel') !!}</a>
            </div>
        </div>
    @endif

    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</div>

@section('scripts')
    $(document).on('change','#accepted',function(e){
        $('#isAgeSelected').disabled = $('#accepted').prop('checked');
    });
@endsection