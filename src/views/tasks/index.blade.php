@extends('master')

@section('content')

    <script>

        function updateTaskInfo() {

            $.get(allApiUrl,
                    function (tasks) {

                        tasks.forEach(updateSingleTaskInfo);
                    }
            )

            $(".data-task-count").html(runningTasksCount);

        }

        function updateSingleTaskInfo(task, i, arr) {
            console.log(task);

            setProgress(task.id, task.progress);

            if (task.running) {
                setRunningAlt(task.id);
            }
            else {
                setStoppedAlt(task.id);
            }
        }


        $(function () {
            allAjaxInterval = setInterval('updateTaskInfo();', ajax_rate);
        })


    </script>

    <h1>Задачи</h1>
    <hr>

    @foreach($tasks as $task)
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-1">

                        <button data-task-id="{{$task->id}}" style="display: none;"
                                onclick="task_control({{$task->id}},'stop');setStoppedAlt({{$task->id}})"
                                class="data-btn_stop btn btn-default btn-lg">
                            <i class="fa fa-stop"></i>
                        </button>

                        <button data-task-id="{{$task->id}}"
                                onclick="task_control({{$task->id}},'start');setRunningAlt({{$task->id}})"
                                class="data-btn_start btn btn-default btn-lg">
                            <i class="fa fa-play"></i>
                        </button>

                    </div>

                    <div class="col-xs-9">
                        <span style="font-size: 20px;">

                            <a href="{{ url( 'tasks/'.$task->id ) }}">{{ $task->title }}</a>

                        <button data-task-id="{{$task->id}}" style="color:maroon"
                                onclick="task_control({{$task->id}},'unlock');unlockAlt({{$task->id}})"
                                class="data-btn_unlock btn btn-link btn-xs">
                            <i class="fa fa-unlock-alt" style="color:maroon"></i>
                            unlock
                        </button>


                        </span>
                        <br>
                        <span class="help">{{ $task->description }}</span>
                    </div>

                    <div class="col-xs-2">
                    <span class="help-block">
                   <i class="fa fa-clock-o"></i> <span>{{ strftime('%a %b %d %H:%M', strtotime( $task->last_run ) )  }} </span> <br>
                   <i class="fa fa-clock-o {{ $task->nextRunDate() ? ( ( new DateTime($task->nextRunDate()) < new DateTime('now') ) ? 'text-danger' : 'text-primary' ) : '' }}"></i>  <span
                                class=" {{ $task->nextRunDate() ? ( ( new DateTime($task->nextRunDate()) < new DateTime('now') ) ? 'text-danger' : 'text-primary' ) : '' }}">{{ $task->nextRunDate() ? strftime('%a %b %d %H:%M', strtotime(  $task->nextRunDate() )  ): 'не запланировано'  }}</span>
                    </span>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="progress" style="height:5px; margin-bottom:0px;margin-top:15px;">
                            <div data-task-id="{{$task->id}}" class="data-progress progress-bar progress-bar-striped"
                                 role="progressbar"
                                 aria-valuenow="0"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:0%">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

@stop