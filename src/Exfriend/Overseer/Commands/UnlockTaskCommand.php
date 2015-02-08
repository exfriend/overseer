<?php

namespace Exfriend\Overseer\Commands;

use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\TaskManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class UnlockTaskCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:unlock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unlock failed task';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $task_id = $this->argument( 'task_id' );

        $manager = new TaskManager( Task::find( $task_id ) );
        $manager->unlock();
    }

    protected function getArguments()
    {
        return array(
            array( 'task_id', InputArgument::REQUIRED, 'Valid id for Task model.' ),
        );
    }

}
