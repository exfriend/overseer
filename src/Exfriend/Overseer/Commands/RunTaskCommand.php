<?php

namespace Exfriend\Overseer\Commands;

use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\TaskManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;


class RunTaskCommand extends Command {

    protected $name = 'task:run';
    protected $description = 'Perform task in background';
    private $php_path = '/usr/bin/php';


    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $manager = new TaskManager( Task::findOrFail( $this->argument( 'task_id' ) ) );
        if ( !( $this->option( 'bg' ) ) )
        {
            $this->info( 'Running without bg' );
            $manager->run( $this );
        }
        else
        {
            $this->info( 'Running in bg' );

            $manager->runInBackground();
        }


    }

    protected function getArguments()
    {
        return array(
            array( 'task_id', InputArgument::REQUIRED, 'Valid id for Task model.' ),
        );
    }

    protected function getOptions()
    {
        return array(
            array( 'bg', null, InputOption::VALUE_NONE, 'Ololo' )
        );
    }

}
