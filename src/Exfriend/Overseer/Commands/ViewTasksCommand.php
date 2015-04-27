<?php namespace Exfriend\Overseer\Commands;


use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\TaskManager;
use Illuminate\Console\Command;


class ViewTasksCommand extends Command {

    protected $name = 'task:list';
    protected $description = 'Show all tasks';


    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $rows = [];

        $tasks = Task::all();

        foreach ( $tasks as $task )
        {
            $tm = new TaskManager($task);

            $rows[] = [
                $task->id,
                $task->title,
                $task->is_running ? '<fg=yellow;options=bold>'.$tm->info->getProgress().'%</>' : '<fg=magenta>No</>',
                $task->last_run ,
            ];
        }


        $table = $this->getHelper( 'table' );
        $this->line('');
        $this->table( array( 'id', 'title', 'running', 'last run' ), $rows );
        $this->line('');

    }

    protected function getArguments()
    {
        return array();
    }

    protected function getOptions()
    {
        return array();
    }

}
