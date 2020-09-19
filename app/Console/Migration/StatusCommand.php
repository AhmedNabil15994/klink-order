<?php
namespace App\Console\Migration;

use App\Library\Venture;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Migrations\StatusCommand as BaseStatusCommand;
use Illuminate\Support\Facades\Artisan;

class StatusCommand extends BaseStatusCommand
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
    public function makeMigrate($path)
    {
        $options = $this->options();
        $options['path']  = $path;
        $this->call('migrate:status', [
            '--path'=>$options
        ]);
    }
    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        array_push(
            $options,
            ['all', null, InputOption::VALUE_NONE, 'Status for migrations from all available modules.'],
            ['modules', null, InputOption::VALUE_OPTIONAL, 'Status for migrations from given modules.']
        );
        return $options;
    }
}
