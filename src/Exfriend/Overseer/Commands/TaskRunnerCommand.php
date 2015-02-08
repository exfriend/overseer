<?php

namespace Exfriend\Overseer\Commands;

use DateTime;
use Exfriend\Overseer\Models\Cronjob;
use Exfriend\Overseer\Models\CronjobRepo;
use Illuminate\Console\Command;

class TaskRunnerCommand extends Command {

    protected $name = 'task:cron';
    protected $description = 'Process cron jobs for application';
    private $cronjobRepo;

    public function __construct()
    {
        parent::__construct();
        $this->cronjobRepo = new CronjobRepo();
    }

    protected function isTimeToExecute( Cronjob $job )
    {
        $job->task->reload();
        $dt1 = new DateTime( $job->task->nextRunDate() );
        $dt2 = new DateTime( 'now' );

        $this->info( 'Task "' . $job->task->title . '" expected to run on ' . $dt1->format( 'D M d H:i' ) . '.' );

        return ( $dt1 < $dt2 );
    }

    public function processCronjob( Cronjob $job )
    {

        if ( $this->isTimeToExecute( $job ) )
        {
            // Run the task in background

            $this->info( 'Running scheduled task "' . $job->task->title . '".' );

            \Artisan::call( 'task:run', [ 'task_id' => $job->task->id ] );

            return true;
        }

        return false;

    }

    public function fire()
    {
        $isSomethingToRun = false;
        $cronjobs = $this->cronjobRepo->getAllActive();
        foreach ( $cronjobs as $job )
        {
            $isSomethingToRun = $isSomethingToRun || $this->processCronjob( $job );
        }

        if ( !$isSomethingToRun )
        {
            $this->comment( 'Nothing to run, Forrest.' );
        }

    }

}
