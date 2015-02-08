<?php

namespace Exfriend\Overseer\Procedures;


use Config;
use Exfriend\Overseer\Models\Task;
use File;

class FileProcedureInfo implements ProcedureInfoInterface {


    /**
     * @var Task
     */
    private $task;
    private $data_folder;
    private $files;

    function __construct( Task $task )
    {
        $this->task = $task;

        $this->data_folder = Config::get( 'overseer::data_folder' );

        $this->task_folder = $this->data_folder . DIRECTORY_SEPARATOR
            . $this->task->id . DIRECTORY_SEPARATOR;

        $this->files = [
            'state' => $this->task_folder . 'state.txt',
            'stop' => $this->task_folder . 'stop.txt',
            'lock' => $this->task_folder . 'lock.txt',
            'log' => $this->task_folder . 'log.txt',
            'short_log' => $this->task_folder . 'short_log.txt',
        ];
    }


    public function taskFolderExists()
    {
        return File::exists( $this->task_folder );
    }

    // -------------------------------------------------------------------
    // --[ getters ]------------------------------------------------------
    // -------------------------------------------------------------------


    public function getRunning()
    {
        return File::exists( $this->files[ 'state' ] );
    }

    public function getProgress()
    {
        if ( !$this->getRunning() )
        {
            return 0;
        }

        return File::get( $this->files[ 'state' ] );

    }

    public function getLocked()
    {
        if ( !$this->getRunning() )
        {
            return false;
        }

        return File::get( $this->files[ 'lock' ] );
    }

    public function getLog()
    {
        if ( !$this->getRunning() )
        {
            return false;
        }

        return File::get( $this->files[ 'short_log' ] );
    }

    public function getStop()
    {
        if ( !$this->getRunning() )
        {
            return false;
        }

        return File::get( $this->files[ 'stop' ] );
    }

    public function getInfo()
    {
        return array(
            'running' => $this->getRunning(),
            'locked' => $this->getLocked(),
            'stopping' => $this->getStop(),
            'progress' => $this->getProgress(),
            'short_log' => $this->getLog(),
        );
    }


    // -------------------------------------------------------------------
    // --[ setters ]------------------------------------------------------
    // -------------------------------------------------------------------

    public function setRunning( $running )
    {
        if ( !$this->taskFolderExists() )
        {
            if ( $running )
            {
                File::makeDirectory( $this->task_folder, 777, true );
                $this->setProgress( 0 );
                return true;
            }

            return false;
        }

        if ( $running == false )
        {
            File::deleteDirectory( $this->task_folder );
        }

    }

    public function setProgress( $progress )
    {

        if ( !$this->taskFolderExists() )
        {
            return false;
        }

        File::put( $this->files[ 'state' ], $progress );
    }

    public function setLocked( $locked )
    {

        if ( !$this->taskFolderExists() )
        {
            return false;
        }

        if ( $locked )
        {
            File::put( $this->files[ 'lock' ], $locked );
        }
        else
        {
            File::delete( $this->files[ 'lock' ] );
        }
    }

    public function setStop( $stop )
    {
        if ( !$this->taskFolderExists() )
        {
            return false;
        }

        File::put( $this->files[ 'stop' ], $stop );
    }

    public function setShortLog( $array )
    {
        if ( !$this->taskFolderExists() )
        {
            return false;
        }

        File::put( $this->files[ 'short_log' ], implode( "\n", $array ) );
    }
}