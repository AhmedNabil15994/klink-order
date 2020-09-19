<?php
namespace App\Console\Migration;

use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Migrations\RefreshCommand as BaseRefreshCommand;

class RefreshCommand extends BaseRefreshCommand
{
    use MigrationTrait;
    /**
     * {@inheritdoc}
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
    protected function makeMigrate($path)
    {
        if (! $this->confirmToProceed()) {
            return;
        }
        // Next we'll gather some of the options so that we can have the right options
        // to pass to the commands. This includes options such as which database to
        // use and the path to use for the migration. Then we'll run the command.
        $database = $this->input->getOption('database');
        // If the "step" option is specified it means we only want to rollback a small
        // number of migrations before migrating again. For example, the user might
        // only rollback and remigrate the latest four migrations instead of all.
        $step = $this->input->getOption('step') ?: 0;
        if ($step > 0) {
            $this->runRollback($database, $path, $step);
        } else {
            $this->runReset($database, $path);
        }
        // The refresh command is essentially just a brief aggregate of a few other of
        // the migration commands and just provides a convenient wrapper to execute
        // them in succession. We'll also see if we need to re-seed the database.
        $this->call('migrate', array_filter([
            '--database' => $database,
            '--path' => $path,
            '--realpath' => $this->input->getOption('realpath'),
            '--force' => true,
        ]));
        if ($this->needsSeeding()) {
            $this->runSeeder($database);
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        array_push(
            $options,
            ['all', null, InputOption::VALUE_NONE, 'Rollback migrations from all available modules.'],
            ['modules', null, InputOption::VALUE_OPTIONAL, 'Rollback migrations from given modules.']
        );
        return $options;
    }
}
