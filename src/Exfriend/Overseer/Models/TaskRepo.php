<?php namespace Exfriend\Overseer\Models;

use Config;
use Exfriend\Overseer\Procedures\FileProcedureInfo;
use File;


class TaskRepo {

    private $log_filename_format = '(\d*?)_(\d*?)_(\d*?)-(\d*?)_(\d*?)_(\d*?)@id(\d*?).log';


    // -------------------------------------------------------------------
    // --[ API methods ]------------------------------------------------------
    // -------------------------------------------------------------------


    public function getAllTasksInfo()
    {
        $data = [ ];

        $task_ids = Task::lists( 'id' );

        foreach ( $task_ids as $k => $task_id )
        {
            $data [ ] = $this->getTaskInfo( $task_id );
        }

        return $data;
    }

    public function getRunningTasksInfo()
    {
        $data = [ ];

        $task_ids = $this->getRunningTaskIds();

        foreach ( $task_ids as $k => $task_id )
        {
            $data [ ] = $this->getTaskInfo( $task_id );
        }

        return $data;
    }

    public function getTaskInfo( $task_id )
    {
        $task = Task::find( $task_id );
        $task_info = new FileProcedureInfo( $task );

        return array(
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'last_run' => $task->last_run,

            'running' => $task_info->getRunning(),
            'progress' => $task_info->getProgress(),
            'short_log' => $task_info->getLog(),
        );

    }


    // -------------------------------------------------------------------
    // --[ crappy shit ]------------------------------------------------------
    // -------------------------------------------------------------------

    public function isAbleToRun()
    {
        return ( !self::isRunning( $this->task->id ) );
    }

    public static function isRunning( $task_id )
    {
        return in_array( $task_id, self::getRunningTaskIds() );
    }

    public static function getRunningTaskIds()
    {
        $runningTasks = [ ];

        $d = File::directories( Config::get( 'overseer::data_folder' ) );

        foreach ( $d as $v )
        {
            $runningTasks [ ] = basename( $v );
        }

        return $runningTasks;
    }

    public function getAll()
    {
        return Task::all();
    }

    public function getTaskLogs( $task_id, $limit = 100 )
    {
        $ret = [ ];
        $files = \File::files( Config::get( 'overseer::external_log_folder' ) . '/' );
        rsort( $files );

        $files = array_slice( $files, 0, $limit );

        foreach ( $files as $k => $f )
        {
            if ( !$dat = $this->parseLogFileName( $f, $task_id ) )
            {
                continue;
            }

            $ret [ ] = $dat;

        }
        return $ret;
    }

    /**
     * @param $f
     * @param $task_id
     * @return int
     */
    protected function parseLogFileName( $f, $task_id )
    {
        if ( !preg_match( '~' . $this->log_filename_format . '~ims', $f, $fname ) )
        {
            return false;
        }

        if ( $fname[ 7 ] != $task_id )
        {
            return false;
        }

        $ret [ ] = array(
            'filename' => $fname[ 0 ],
            'date' => $fname[ 3 ] . '.' . $fname[ 2 ] . '.' . $fname[ 1 ] . ' ' . $fname[ 4 ] . ':' . $fname[ 5 ] . ':' . $fname[ 6 ]
        );

        return array(
            'filename' => $fname[ 0 ],
            'date' => $fname[ 3 ] . '.' . $fname[ 2 ] . '.' . $fname[ 1 ] . ' ' . $fname[ 4 ] . ':' . $fname[ 5 ] . ':' . $fname[ 6 ]
        );
    }
} 