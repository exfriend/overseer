@extends('master')

@section('content')

    <ul class="timeline">
        <li class="timeline-inverted">
            <div class="timeline-badge danger"><i class="glyphicon glyphicon-calendar"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Dummy Task</h4>

                    <p>
                        <small class="text-muted"><i class="glyphicon glyphicon-time"></i> 03.11.2014 08:00</small>
                    </p>
                </div>
                <div class="timeline-body">
                    <p>Test task</p>
                </div>
            </div>
        </li>
        <li>
            <div class="timeline-badge danger"><i class="glyphicon glyphicon-calendar"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">Dummy Task</h4>

                    <p>
                        <small class="text-muted"><i class="glyphicon glyphicon-time"></i> 03.11.2014 08:00</small>
                    </p>
                </div>
                <div class="timeline-body">
                    <p>Test task</p>
                </div>
            </div>
        </li>
    </ul>
@stop