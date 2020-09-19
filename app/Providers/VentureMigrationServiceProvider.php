<?php
namespace App\Providers;
use App\Console\Migration\MigrateCommand;
use Illuminate\Database\MigrationServiceProvider;
use App\Console\Migration\RollbackCommand;
use App\Console\Migration\RefreshCommand;
use App\Console\Migration\StatusCommand;


class VentureMigrationServiceProvider extends MigrationServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->registerMigrateCommand();
        $this->registerMigrateRollbackCommand();
        $this->registerMigrateRefreshCommand();
        $this->registerMigrateStatusCommand();
    }
    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator']);
        });
    }
    protected function registerMigrateRollbackCommand()
    {
        $this->app->singleton('command.migrate.rollback', function ($app) {
            return new RollbackCommand($app['migrator']);
        });
    }
    protected function registerMigrateRefreshCommand()
    {
        $this->app->singleton('command.migrate.refresh', function ($app) {
            return new RefreshCommand($app['migrator']);
        });
    }
    protected function registerMigrateStatusCommand()
    {
        $this->app->singleton('command.migrate.status', function ($app) {
            return new StatusCommand($app['migrator']);
        });
    }
}