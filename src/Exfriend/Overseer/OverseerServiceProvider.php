<?php namespace Exfriend\Overseer;


use Illuminate\Support\ServiceProvider;

class OverseerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRunTaskCommand();
        $this->registerStopTaskCommand();
        $this->registerCronCommand();
        $this->registerUnlockCommand();
        $this->registerListCommand();

        $this->commands( [
            'task.run',
            'task.stop',
            'task.cron',
            'task.unlock',
            'task.list',
        ] );
    }

    private function registerRunTaskCommand()
    {
        $this->app[ 'task.run' ] = $this->app->share( function ( $app )
        {
            return new Commands\RunTaskCommand();
        } );
    }


    private function registerListCommand()
    {
        $this->app[ 'task.list' ] = $this->app->share( function ( $app )
        {
            return new Commands\ViewTasksCommand();
        } );
    }
    private function registerStopTaskCommand()
    {
        $this->app[ 'task.stop' ] = $this->app->share( function ( $app )
        {
            return new Commands\StopTaskCommand();
        } );
    }

    private function registerCronCommand()
    {
        $this->app[ 'task.cron' ] = $this->app->share( function ( $app )
        {
            return new Commands\TaskRunnerCommand();
        } );
    }

    private function registerUnlockCommand()
    {
        $this->app[ 'task.unlock' ] = $this->app->share( function ( $app )
        {
            return new Commands\UnlockTaskCommand();
        } );
    }

    public function boot()
    {
        $this->package( 'exfriend/overseer' );

        include __DIR__ . '/../../helpers.php';
        include __DIR__ . '/../../routes.php';
//        include __DIR__ . '/../../lang/en/messages.php';
//        include __DIR__ . '/../../lang/ru_RU.UTF-8/messages.php';

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
