<?php namespace Exfriend\Overseer\Commands;


use Exfriend\Overseer\Models\Task;
use Exfriend\Overseer\TaskManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;


class ViewTasksCommand extends Command {

    protected $name = 'task:list';
    protected $description = 'Show all tasks';


    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $tasks = Task::all();

        $this->table([1,2,3],[1,2,3]);

    }

    protected function getArguments()
    {
        return array(
        );
    }

    protected function getOptions()
    {
        return array(
        );
    }

}
