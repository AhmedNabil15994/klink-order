<?php

namespace App\Console\Migration;

use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;
use Illuminate\Database\Migrations\Migrator;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    use MigrationTrait;

    public function __construct(Migrator $migrator)
    {
        $this->signature .= "
                {--all : Rul all migrations to all modules}
                {--modules= : run migrations to specific module.}
        ";
        parent::__construct($migrator);
    }
    protected function makeMigrate($path)
    {
        if (! $this->confirmToProceed()) {
            return;
        }
        $this->prepareDatabase();
        // Next, we will check to see if a path option has been defined. If it has
        // we will use the path relative to the root of this installation folder
        // so that migrations may be run for any path within the applications.
        $this->migrator->setOutput($this->output)
                ->run($path, [
                    'pretend' => $this->option('pretend'),
                    'step' => $this->option('step'),
                ]);
        // Finally, if the "seed" option has been given, we will re-run the database
        // seed task to re-populate the database, which is convenient when adding
        // a migration and a seed at the same time, as it is only this command.
        if ($this->option('seed') && ! $this->option('pretend')) {
            $this->call('db:seed', ['--force' => true]);
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->runFor(config('modules'));
        } elseif ($schemas = $this->option('modules')) {
            $this->runFor($this->getValidModules($schemas));
        } else {
            parent::handle();
        }
    }
}
