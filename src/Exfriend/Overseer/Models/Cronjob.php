<?php

namespace Exfriend\Overseer\Models;

use Cron\CronExpression;

class Cronjob extends \Eloquent {

    protected $table = 'laravel_crontab';

    protected $fillable = [
        'active',
        'task_id',
        'minute',
        'hour',
        'day_of_month',
        'day_of_week',
        'month'
    ];


    public function task()
    {
        return $this->belongsTo( '\Exfriend\Overseer\Models\Task' );
    }

    public function nextRunDate( $format = 'd.m.Y H:i' )
    {
        return CronExpression::factory( $this->toCronString() )->getNextRunDate( $this->task->last_run )->format( $format );
    }

    public function toCronString()
    {
        return $this->minute . ' ' . $this->hour . ' ' . $this->day_of_month . ' ' . $this->month . ' ' . $this->day_of_week;
    }

    public function previousRunDate( $format = 'd.m.Y H:i' )
    {
        return CronExpression::factory( $this->toCronString() )->getPreviousRunDate( $this->task->last_run )->format( $format );
    }
}