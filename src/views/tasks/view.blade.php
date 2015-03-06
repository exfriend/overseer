@extends('master')

@section('content')

    <div ng-controller="SingleTaskController" ng-init="singleTaskId='{{$task->id}}'">

        <h1>{{ $task->title }}
            <small>{{ $task->description }}</small>
        </h1>


        <h3>{{ trans('overseer::messages.controls') }} </h3>
        <hr>

        <button ng-click="start()" ng-if="!task.running" class="btn btn-default"><i class="fa fa-play"></i>
            {{ trans('overseer::messages.action_run') }}
        </button>
        <button ng-click="stop()" ng-if="task.running" class="btn btn-default"><i class="fa fa-stop"></i>
            {{ trans('overseer::messages.action_stop') }}
        </button>
        <button  ng-click="unlock()" ng-if="task.running" class="btn btn-danger"><i class="fa fa-unlock-alt"></i>
            {{ trans('overseer::messages.action_unlock') }}
        </button>


        <br><br>

        <div class="progress">
            <div style="width: @{{ task.progress }}%;" class="data-progress progress-bar progress-bar-danger"
                 role="progressbar"></div>
        </div>

        <h3>{{ trans('overseer::messages.log') }}</h3>
        <hr>

        <div class="panel panel-default">
            <div class="data-log panel-body"
                 style="font-family: monospace; background:#222; color: #fff; max-height: 500px; overflow-y: scroll"
                 ng-bind-html="task.short_log"></div>
        </div>

        <br>
        <br>

        <h3>{{ trans('overseer::messages.history') }}
            <small>{{ trans('overseer::messages.past_runs') }}</small>
        </h3>
        <hr>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>{{ trans('overseer::messages.date') }}</th>
                <th>{{ trans('overseer::messages.event') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse( $logs as $log )
                <tr>
                    <td>{{ $log['date'] }}</td>
                    <td>
                        <a href="{{ url( 'tasks/history/'.$log['filename'] ) }}"> {{ trans('overseer::messages.view_log') }} </a>
                    </td>
                </tr>
            @empty
                <tr class="bg-warning">
                    <td colspan="8" style="text-align: center">{{ trans('overseer::messages.no_runs') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>


        <br>
        <br>

        <h3>{{ trans('overseer::messages.scheduler') }}
            <small>{{ trans('overseer::messages.cronjobs') }}</small>
        </h3>
        <hr>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>{{ trans('overseer::messages.active') }}</th>
                <th>{{ trans('overseer::messages.minute') }}</th>
                <th>{{ trans('overseer::messages.hour') }}</th>
                <th>{{ trans('overseer::messages.day_of_month') }}</th>
                <th>{{ trans('overseer::messages.month') }}</th>
                <th>{{ trans('overseer::messages.day_of_week') }}</th>
                <th>{{ trans('overseer::messages.last_run') }}</th>
                <th>{{ trans('overseer::messages.next_run') }}</th>
            </tr>
            </thead>
            <tbody>

            @forelse( $task->cronjobs->all() as $job )
                <tr>
                    <td><input type="checkbox" {{ $job->active ? 'checked' : '' }}/></td>
                    <td> {{ $job->minute }} </td>
                    <td> {{ $job->hour }} </td>
                    <td> {{ $job->day_of_month }} </td>
                    <td> {{ $job->month }} </td>
                    <td> {{ $job->day_of_week }} </td>
                    <td> {{ $job->previousRunDate() }} </td>
                    <td> {{ $job->nextRunDate() }} </td>
                </tr>

            @empty
                <tr class="bg-warning">
                    <td colspan="8" style="text-align: center">{{ trans('overseer::messages.no_cronjobs') }}</td>
                </tr>
            @endforelse

            </tbody>
        </table>

    </div>


@stop