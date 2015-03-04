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


    <h3>Управление </h3>
    <hr>


    <button id="btn_start" data-task-id="{{$task->id}}" onclick="task_control({{$task->id}},'start')"
            class="data-btn_start {{ $state['running'] ? 'disabled' : '' }} btn btn-default"><i class="fa fa-play"></i>
        Запустить
    </button>
    <button id="btn_stop" data-task-id="{{$task->id}}" onclick="task_control({{$task->id}},'stop')"
            class="data-btn_stop {{ $state['running'] ? '' : 'disabled' }} btn btn-default"><i class="fa fa-stop"></i>
        Остановить
    </button>
    <button id="btn_stop" data-task-id="{{$task->id}}" onclick="task_control({{$task->id}},'unlock')"
            class="data-btn_unlock btn btn-danger"><i class="fa fa-unlock-alt"></i>
        Unlock
    </button>



    <br><br>

    <div class="progress">
        <div data-task-id="{{$task->id}}" class="data-progress progress-bar progress-bar-danger" style="width: 0%;"
             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" role="progressbar">
        </div>
    </div>


    <h3>Журнал</h3>
    <hr>

    <div class="panel panel-default">
        <div data-task-id="{{$task->id}}" class="data-log panel-body"
             style=" font-family: monospace; background:#222; color: #fff; max-height: 500px; overflow-y: scroll"></div>
    </div>

    <br>
    <br>



    <h3>История
        <small>Предыдущие запуски</small>
    </h3>
    <hr>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>дата</th>
            <th>событие</th>
        </tr>
        </thead>
        <tbody>
        @forelse( $logs as $log )
            <tr>
                <td>{{ $log['date'] }}</td>
                <td><a href="{{ url( 'tasks/history/'.$log['filename'] ) }}"> Просмотреть журнал </a></td>
            </tr>
        @empty
            <tr class="bg-warning">
                <td colspan="8" style="text-align: center">задание еще не запускалось</td>
            </tr>
        @endforelse
        </tbody>
    </table>


    <br>
    <br>

    <h3>Планировщик
        <small>Запланированные cron-задачи</small>
    </h3>
    <hr>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>вкл</th>
            <th>минута</th>
            <th>час</th>
            <th>число</th>
            <th>месяц</th>
            <th>день недели</th>
            <th>последний запуск</th>
            <th>следующий запуск</th>
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
                <td colspan="8" style="text-align: center">нет запланированных запусков</td>
            </tr>
        @endforelse

        </tbody>
    </table>







@stop