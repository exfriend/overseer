<?php namespace Exfriend\Overseer;

use App;
use Exception;
use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\Procedures\FileProcedureInfo;

class TaskManager {

    protected $data_folder;
    private $task;

    public function runInBackground()
    {
        $command = '/usr/bin/php' . " -q " . base_path() . "/artisan task:run " . $this->task->id . " < /dev/null > script.log &";
        shell_exec( $command );
    }

    public function run( $console = false, $force = false )
    {

        if ( !$force && $this->info->getLocked() )
        {
            throw new Exception( 'Unable to run task (Task is locked).' );
        }

        $this->lock();
        $this->task->setRunning();

        $command = App::make( $this->task->class_name, [ $this->task, $console ] );
        $command->run();

        $this->task->setFinished();
        $this->unlock();

    }


    public function stop()
    {
        $this->info->setStop( true );
    }


    public function unlock()
    {
        $this->info->setLocked( false );
        $this->info->setRunning( false );
    }

    public function lock()
    {
        $this->info->setRunning( true );
        $this->info->setLocked( true );
        $this->info->setStop( false );
    }


    public function __construct( Task $task )
    {
        $this->task = $task;
        $this->info = new FileProcedureInfo( $task );
    }


}