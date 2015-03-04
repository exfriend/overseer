<?php
namespace Exfriend\Overseer;

use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\Models\TaskRepo;
use Illuminate\Routing\Controller;

class TasksController extends Controller {

    protected $taskRepo;

    function __construct( TaskRepo $taskRepo )
    {
        $this->taskRepo = $taskRepo;
    }


    /*
     * ------------------------------------
     *    Task API Section
     * ------------------------------------
     */


    public function running()
    {
        $data = $this->taskRepo->getRunningTasksInfo();
        return $data;
    }

    public function all()
    {
        $data = $this->taskRepo->getAllTasksInfo();
        return $data;
    }

    public function single( $id )
    {


        $data = $this->taskRepo->getTaskInfo( $id );

        $data[ 'short_log' ] = present_logs_for_web( $data[ 'short_log' ] );

        return $data;
    }


    /*
     * ------------------------------------
     *    Task Control Section
     * ------------------------------------
     */

    public function start( Task $task )
    {
        $manager = new TaskManager( $task );
        $manager->runInBackground();

        return json_encode( [ 'status' => 'started' ] );
    }

    public function stop( $task )
    {
        $cmd = new TaskManager( $task );
        $cmd->stop();
        return json_encode( [ 'status' => 'stopped' ] );
    }

    public function unlock( $task )
    {
        $cmd = new TaskManager( $task );
        $cmd->unlock();
        return json_encode( [ 'status' => 'unlocked' ] );
    }


    /*
     * ------------------------------------
     *    Task Admin Section
     * ------------------------------------
     */

    public function timeline()
    {
        $tasks = $this->taskRepo->getAll();
        $task_data = [ ];

        foreach ( $tasks as $tk => $task )
        {
            $task_data[ $task->id ] = $this->taskRepo->getTaskData( $task->id );
        }


        return View::make( 'overseer::tasks.timeline' );
    }

    public function index()
    {
        $tasks = $this->taskRepo->getAll();

        return View::make( 'overseer::tasks.index' )
            ->with( 'tasks', $tasks );
    }

    public function history( $log )
    {
        $path = app_path() . '/storage/logs/tasks/' . $log;

        if ( File::extension( $path ) == 'log' and $log_data = File::get( $path ) )
        {
            return View::make( 'overseer::tasks.history' )->with( 'log_data', $log_data );
        }
        else
        {
            return Redirect::route( 'tasks' );
        }

    }

    public function show( $task )
    {
        $logs = $this->taskRepo->getTaskLogs( $task->id );
        $state = $this->taskRepo->getTaskInfo( $task->id );

        return View::make( 'overseer::tasks.view' )->with( compact( 'task', 'logs', 'state' ) );
    }


}