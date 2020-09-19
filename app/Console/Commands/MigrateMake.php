<?php

namespace App\Console\Commands;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Support\Facades\File;

class MigrateMake extends MigrateMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public function __construct(
        \Illuminate\Database\Migrations\MigrationCreator $creator,
        \Illuminate\Support\Composer $composer
    ) {
        $this->signature .= ' {--module= : the module name}';
        parent::__construct($creator, $composer);
    }
    

    /**
     * The console command description.
     *
     * @var string
     */
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
    protected function getMigrationPath()
    {
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return ! $this->usingRealPath()
                            ? $this->laravel->basePath().'/'.$targetPath
                            : $targetPath;
        }
        if ($this->option('module')) {
            if (!file_exists(app_path('Modules/'.$this->option('module').'/database/'))) {
                File::makeDirectory( app_path('Modules/'.$this->option('module').'/database/'));
                
            }
            return app_path('Modules/'.$this->option('module').'/database/migrations');
        }
        if(!file_exists(app_path('Modules/'.$this->option('module').'/database/migrations'))){
            File::makeDirectory( app_path('Modules/'.$this->option('module').'/database/migrations/'));
        }

        return parent::getMigrationPath();
    }
}
