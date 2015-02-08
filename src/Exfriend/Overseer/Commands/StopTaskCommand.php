<?php

namespace Exfriend\Overseer\Commands;

use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\TaskManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class StopTaskCommand extends Command {

    protected $name = 'task:stop';
    protected $description = 'Stop running task by id.';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $task_id = $this->argument( 'task_id' );
        $cmd = new TaskManager( Task::findOrFail( $task_id ) );
        $cmd->stop();
    }

    protected function getArguments()
    {
        return array(
            array( 'task_id', InputArgument::REQUIRED, 'Valid id for running Task model.' ),
        );
    }

}
