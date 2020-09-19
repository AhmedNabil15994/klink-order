<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class ModuleMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (file_exists(app_path('Modules/'.$name))) {
            $this->error('the Modules already exists!');
        } else {
            File::copyDirectory(__DIR__.'/stubs/Module', app_path('Modules/'.$name));
            $path = config_path('modules.php');
            $contents = config('modules');

            array_push($contents, $name);
            $contents = json_encode($contents);
            $contents = "<?php\n  return ".$contents.";";
            // and so on

            File::put($path, $contents);
            $this->info('modules created successfully');
        }
    }
}
