@extends('master')

@section('content')

    <script>
        var app_task_id = {{ $task->id  }};

        function getTaskInfo(task_id) {

            $.get(api_url + task_id,
                    function (task_info) {
                        processTaskInfo(task_info);
                    }
            )
        }

        function processTaskInfo(task_info) {

            console.log(task_info.progress);

            setProgress(task_info.id, task_info.progress);
            setLog(task_info.id, task_info.short_log);

            if (task_info.running) {
                setRunning(task_info.id);
            }
            else {
                setStopped(task_info.id);
            }
        }

        $(function () {
            ajax_interval = setInterval('getTaskInfo(app_task_id)', ajax_rate);
        })

    </script>


    <h1>{{ $task->title }}
        <small>{{ $task->description }}</small>
    </h1>


    <h3>{{ trans('overseer::messages.controls') }} </h3>
    <hr>


    <button id="btn_start" data-task-id="{{$task->id}}" onclick="task_control({{$task->id}},'start')"
            class="data-btn_start {{ $state['running'] ? 'disabled' : '' }} btn btn-default"><i class="fa fa-play"></i>
        {{ trans('overseer::messages.action_run') }}
    </button>
    <button id="btn_stop" data-task-id="{{$task->id}}" onclick="task_control({{$task->id}},'stop')"
            class="data-btn_stop {{ $state['running'] ? '' : 'disabled' }} btn btn-default"><i class="fa fa-stop"></i>
        {{ trans('overseer::messages.action_stop') }}
    </button>
    <button id="btn_stop" data-task-id="{{$task->id}}" onclick="task_control({{$task->id}},'unlock')"
            class="data-btn_unlock btn btn-danger"><i class="fa fa-unlock-alt"></i>
        {{ trans('overseer::messages.action_unlock') }}
    </button>



    <br><br>

    <div class="progress">
        <div data-task-id="{{$task->id}}" class="data-progress progress-bar progress-bar-danger" style="width: 0%;"
             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" role="progressbar">
        </div>
    </div>


    <h3>{{ trans('overseer::messages.log') }}</h3>
    <hr>

    <div class="panel panel-default">
        <div data-task-id="{{$task->id}}" class="data-log panel-body"
             style=" font-family: monospace; background:#222; color: #fff; max-height: 500px; overflow-y: scroll"></div>
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
                <td><a href="{{ url( 'tasks/history/'.$log['filename'] ) }}"> {{ trans('overseer::messages.view_log') }} </a></td>
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







@stop