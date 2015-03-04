<?php


Route::model( 'task', '\Exfriend\Overseer\Models\Task' );
/*
 * Package:TaskManager
 */
Route::get( 'tasks',
    [
        'as' => 'tasks',
        'uses' => '\Exfriend\Overseer\TasksController@index'
    ]
)->before( 'auth' );


Route::get( 'tasks/timeline',
    [
        'as' => 'tasks.timeline',
        'uses' => '\Exfriend\Overseer\TasksController@timeline'
    ]
)->before( 'auth' );

Route::get( 'tasks/history/{log}',
    [
        'as' => 'tasks.history',
        'uses' => '\Exfriend\Overseer\TasksController@history'
    ]
)->before( 'auth' );

Route::get( 'tasks/{task}',
    [
        'as' => 'tasks.view',
        'uses' => '\Exfriend\Overseer\TasksController@show'
    ]
)->before( 'auth' );


// -------------------------------------------------------------------
// --[ task api ]-----------------------------------------------------
// -------------------------------------------------------------------

Route::get( 'api/tasks/running',
    [
        'as' => 'running_tasks_api',
        'uses' => '\Exfriend\Overseer\TasksController@running'
    ]
)->before( 'auth' );

Route::get( 'api/tasks/all',
    [
        'as' => 'all_tasks_api',
        'uses' => '\Exfriend\Overseer\TasksController@all'
    ]
)->before( 'auth' );


Route::get( 'api/tasks/{task}/start',
    [
        'as' => 'tasks.start',
        'uses' => '\Exfriend\Overseer\TasksController@start'
    ]
)->before( 'auth' );

Route::get( 'api/tasks/{task}/stop',
    [
        'as' => 'tasks.stop',
        'uses' => '\Exfriend\Overseer\TasksController@stop'
    ]
)->before( 'auth' );

Route::get( 'api/tasks/{task}/unlock',
    [
        'as' => 'tasks.unlock',
        'uses' => '\Exfriend\Overseer\TasksController@unlock'
    ]
)->before( 'auth' );

Route::get( 'api/tasks/{id}',
    [
        'as' => 'task_info_api',
        'uses' => '\Exfriend\Overseer\TasksController@single'
    ]
)->before( 'auth' );

