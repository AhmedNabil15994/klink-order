<?php

namespace App\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class ControllerMake extends ControllerMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:controller';
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
    public function __construct(\Illuminate\Filesystem\Filesystem $files)
    {
        parent::__construct($files);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('module')) {
            
            return $rootNamespace.'\Modules\\'.$this->option('module').'\Controllers';
        }
        return $rootNamespace.'\Http\Controllers';
    }
    public function handle()
    {
        if ($this->option('module')) {
            if (!file_exists(app_path('Modules/'.$this->option('module')))) {
                $this->error('the modules doesn\'nt exist');
                return 'false';
            }
        }
        parent::handle();
    }
    protected function getOptions()
    {
        $options = parent::getOptions();
        array_push(
            $options,
            ['module', null, InputOption::VALUE_OPTIONAL, 'the name of the module']
           
        );
        return $options;
    }
}
