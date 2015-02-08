<?php

namespace Exfriend\Overseer\Procedures;

use Config;
use Exfriend\Overseer\Commands\RunTaskCommand;
use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\Models\TaskRepo;
use File;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @property Logger logger
 */
abstract class Procedure implements ProcedureInterface {

    public $progress = 0;
    protected $external_log_folder;
    private $taskRepo;
    private $short_log = [ ];

    public function __construct( Task $task, RunTaskCommand $console = null )
    {
        $this->console = $console;
        $this->data_folder = Config::get( 'overseer::data_folder' );
        $this->external_log_folder = Config::get( 'overseer::external_log_folder' );

        $this->task = $task;
        $this->info = new FileProcedureInfo( $task );
        $this->taskRepo = new TaskRepo();
    }


    public function terminate()
    {
        // unlock
        $this->task->setFinished();
        $this->info->setRunning( false );
        exit( 0 );
    }

    public function setProgress( $percent )
    {
        $this->progress = $percent;
        $this->info->setProgress( $this->progress );
    }

    public function checkpoint()
    {
        if ( $this->info->getStop() )
        {
            $this->terminate();
        }
    }


    public function say( $text )
    {
        // full log
        $this->logger->addInfo( $text );
        // short log

        $this->short_log [ ] = '[ ' . date( 'd.m H:i:s' ) . ' ] ' . $text;

        $this->short_log = array_slice( $this->short_log, -50 );

        $this->info->setShortLog( $this->short_log );

        if ( $this->console )
        {
            $this->console->line( date( '[d.m H:i:s] ' ) . $text );
        }
    }

    public function clearOldLogs( $limit = 5 )
    {
        $l = array_slice( $this->taskRepo->getTaskLogs( $this->task->id ), $limit );

        foreach ( $l as $k => $v )
        {
            File::delete( $this->external_log_folder . DIRECTORY_SEPARATOR . $v[ 'filename' ] );
        }
    }

    protected function initLogger()
    {
        $this->clearOldLogs();
        $this->logger = new Logger( 'command' );

        $this->logger->pushHandler( new StreamHandler( $this->info->task_folder . 'log.txt', Logger::INFO ) );
        $this->logger->pushHandler( new StreamHandler( $this->makeLogFilenameForTask(), Logger::INFO ) );


        $this->logger->addInfo( 'Procedure initialized' );
    }

    /**
     * @return string
     */
    protected function makeLogFilenameForTask()
    {
        return $this->external_log_folder . DIRECTORY_SEPARATOR . date( 'Y_m_d-H_i_s' ) . '@id' . $this->task->id . '.log';
    }
} 