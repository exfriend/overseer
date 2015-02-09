<?php

namespace Exfriend\Overseer\Models;

use Carbon\Carbon;

class Task extends \Eloquent {

    protected $table = 'laravel_tasks';
    protected $fillable = [
        'class_name',
        'title',
        'description',
        'is_running',
        'last_run'
    ];

    public function cronjobs()
    {
        return $this->hasMany( '\Exfriend\Overseer\Models\Cronjob' );
    }


    public function setRunning()
    {

        $this->is_running = 1;
        $this->last_run = Carbon::now()->toDateTimeString();
        $this->save();
    }

    public function setFinished()
    {

        $this->is_running = 0;
        $this->save();
    }

    public function reload()
    {
        $instance = new static;
        $instance = $instance->newQuery()->find( $this->{$this->primaryKey} );
        $this->attributes = $instance->attributes;
        $this->original = $instance->original;
    }

    public function nextRunDate()
    {
        $runDates = array();
        foreach ( $this->cronjobs as $k => $job )
        {
            $runDates [ ] = $job->nextRunDate( 'Y-m-d H:i:s' );
        }
        sort( $runDates );

        if ( count( $runDates ) )
        {
            return reset( $runDates );
        }

        return false;

    }
}