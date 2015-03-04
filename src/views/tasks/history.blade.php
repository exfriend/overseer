@extends('master')

@section('content')

    <style>
        .panel-body span {
            font-family: monospace;
        }
    </style>

    <h1>{{ trans('overseer::messages.history_heading') }}</h1>
    <hr>

    <div class="panel panel-default">
        <div class="panel-body" style=" font-family: monospace; background:#222; color: #fff;">
            {{ present_logs_for_web($log_data); }}
        </div>
    </div>

@stop