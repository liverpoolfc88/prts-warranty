<?php

use Illuminate\Support\Facades\Auth;

?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
{{--                <a href="{{ url('many',  $model->id) }}" type="button" style="margin-bottom: 20px" class="btn btn-success">KO`PROQ</a>--}}
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('app.stage.title') }}  </th>
                        <th>{{ trans('app.problem.department_id') }}</th>
                        <th>{{ trans('app.problem.problem_type_id') }}</th>
                        <th>{{ trans('app.problem.part_type') }}</th>
                        <th>{{ trans('app.dealer.name') }}</th>
                        <th>{{ trans('app.problem.vin') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $model->stage->title }}</td>
                        <td>{{ $model->department->name }}</td>
                        <td>{{ $model->problemType->name }}</td>
                        <td>{{ $model->part_type }}</td>
                        <td>{{ $model->dealer->name }}</td>
                        <td>{{ $model->vin }}</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <pre>{{ $model->description }}</pre>
                            <label class="pull-right">{{ $model->contact_info }}</label>
                            <? if ($model->current_stage_id == 5): ?>
                            <p>
                                @role('admin')
                                <a style="background-color: #C71585; " class="btn btn-danger"
                                   href="{{ url('reject',  $model->id) }}">
                                    отказ
                                    {{--                                    {{$model->id}}--}}
                                </a>@endrole
                            </p>
                            <? endif;?>
                            @if($model->attachment)
                                <a href="{{ $model->attachment }}" class="pull-left" target="_blank">
                                    <i class="fa fa-save"></i> {{ trans('app.problemActions.attachment') }}
                                </a>
                            @endif
                            @if($model->video_attachment)
                                <a style="margin-left:25px" href="{{ $model->video_attachment }}" class="pull-left"
                                   target="_blank"><i class="fa fa-save"></i> Видео</a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?
            //                var_dump($pendingProblemAction); die();
            ?>
            @if($doAction)
                @include('problemAction._form')
            @endif
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    @foreach($model->completedProblemActions as $item)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $item->id }}">
                                        {{ $item->stage->stageGroup->title.' / '.$item->stage->title }}
                                    </a>
                                    <span class="pull-right label label-default">{{ $item->created_at }}</span>
                                </h4>

                            </div>
                            <div id="collapse{{ $item->id }}" class="panel-collapse collapse out">
                                @if($item->content)
                                    <div class="panel-body">
                                        <p>{{ $item->content }}</p>
                                        @if($item->stage_id == 3)
                                            <button id="<?=$item->problem_id?>" class="request">запрос на детали</button>
                                        @endif
                                    </div>
                                @endif

                                <div class="panel-footer">
                                    <ul class="list-inline list-unstyled">
                                        <li>
                                            <span><i class="fa fa-male"></i> {{ $item->user->name }} </span>
                                            @if(isset($item->accepted))
                                                @if($item->accepted == 1)
                                                    <i class="fa fa-check text-success"></i>
                                                @else
                                                    <i class="fa fa-minus text-danger"></i>
                                                @endif
                                            @endif
                                        </li>
                                        <li>|</li>
                                        @if($item->attachment)
                                            <li><a href="{{ $item->attachment }}"><i
                                                            class="fa fa-save"></i> {{ trans('app.problemActions.attachment') }}
                                                </a></li>
                                            <li>|</li>
                                        @endif
                                        @if($item->deadline_at)
                                            <li><span class="text-danger"><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($item->deadline_at)->format('Y-m-d') }} </span>
                                            </li>
                                            <li>|</li>
                                        @endif
                                        <li><span class="label label-warning"><i class="fa fa-calendar"></i> {{ $item->updated_at }} </span>
                                        </li>
                                        {{--                                        <li>|sss</li>--}}
                                        <li><span class="label label-info"><i class="fa fa-edit"></i> <a
                                                        style="text-decoration: none; color: #fff;" href="#"
                                                        data-toggle="modal" data-target="#order{{ $item->id }}">Редактиовать </a> </span>
                                        </li>
                                    </ul>

                                    <div class="modal fade" id="order{{ $item->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="order{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="{{ action('HomeController@postEdit') }}"
                                                      data-success="1" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <input type="text" hidden="" value="{{ $item->id }}"
                                                               name="app_id">
                                                        <textarea name="comment" class="form-control"
                                                                  placeholder="Комментарии (не обязательно)">{{ $item->content }}</textarea>
                                                        <br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Закрыть
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Подтвердить
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(function () {
        $('button.request').click(function () {
            // alert('sasa');
            var req = "request";

            var id = $(this).attr('id');

            // console.log(idd);

            // buxam ishledi

            {{--$.ajax({--}}
            {{--    type:'get',--}}
            {{--    url: '{!! Url::to('request') !!}',--}}
            {{--    data: {req:req},--}}
            {{--    success:function () {--}}
            {{--        alert('success');--}}
            {{--    }--}}
            {{--})--}}

            // buxam ishledi

            $.get("{!! Url::to('request') !!}", {request: req, id:id}, function (response) {

                console.log(response);

                if (response == "success") {
                    alert('сообщение отправлено');
                }

            })
        })
    })
</script>