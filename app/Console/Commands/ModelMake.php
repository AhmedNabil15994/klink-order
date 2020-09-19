<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

use Illuminate\Foundation\Console\ModelMakeCommand as Command;
use Illuminate\Support\Str;

// use Illuminate\Console\Command;

class ModelMake extends Command
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
    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function argument($arg=null)
    {
        $optionalName = '';
        if ($this->option('module')) {
            $optionalName = 'Modules/'.$this->option('module').'/Models/';
        }
        return $optionalName.parent::argument($arg);
    }
    public function handle()
    {
        // parent::handle();
        
        if ($this->option('module')) {
            if (!file_exists(app_path('Modules/'.$this->option('module')))) {
                $this->error('the modules doesn\'nt exist');
                return 'false';
            }
        }
        parent::handle();
    }
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));
        $modelName = $this->qualifyClass($this->getNameInput());
        $this->call('make:controller', [
            'name' => "{$controller}Controller",
            '--model' => $this->option('resource') ? $modelName : null,
            '--module'=> $this->option('module'),
        ]);
    }
    protected function pluralStudly($value, $count=2)
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);
        $lastWord = array_pop($parts);
        return implode('', $parts).Str::plural($lastWord, $count);
    }
    protected function createMigration()
    {
        $table = Str::snake($this->pluralStudly(class_basename($this->argument('name'))));
        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }
        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--module'=>$this->option('module'),
            '--create' => $table,
        ]);
        // parent::createMigration();
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
