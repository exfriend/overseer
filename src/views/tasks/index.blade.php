@extends('master')

@section('content')

    <h1>{{ trans('overseer::messages.tasks') }}</h1>
    <hr>



    <div ng-repeat="task in tasks" class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-1">

                    <button ng-click="stop(task.id)" ng-if="task.running" class="btn btn-default btn-lg">
                        <i class="fa fa-stop"></i>
                    </button>

                    <button ng-click="start(task.id)" ng-if="!task.running" class="btn btn-default btn-lg">
                        <i class="fa fa-play"></i>
                    </button>

                </div>

                <div class="col-xs-9">
                        <span style="font-size: 20px;">
                            <a href="{{ url( 'tasks') }}/@{{ task.id }}">@{{ task.title }}</a>
                        </span>
                    <button ng-if="task.running" ng-click="unlock(task.id)" class="btn btn-link btn-xs text-danger">
                        <i class="fa fa-unlock-alt text-danger"></i>
                        {{ trans('overseer::messages.unlock_lc') }}
                    </button>

                    </span>
                    <br>
                    <span class="help">@{{ task.description }}</span>
                </div>

                <div class="col-xs-2">
                    <span class="help-block">
                   <i class="fa fa-clock-o"></i> <span>@{{task.last_run}}</span> <br>
                    </span>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="progress" style="height:5px; margin-bottom:0px;margin-top:15px;">
                        <div class="data-progress progress-bar progress-bar-striped"
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                             style="width:@{{task.progress}}%">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop