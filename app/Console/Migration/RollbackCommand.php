<?php
namespace App\Console\Migration;

use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Migrations\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
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
        $this->migrator->setConnection($this->option('database'));
        $this->migrator->setOutput($this->output)->rollback(
            $path,
            [
                'pretend' => $this->option('pretend'),
                'step' => (int) $this->option('step'),
            ]
        );
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
