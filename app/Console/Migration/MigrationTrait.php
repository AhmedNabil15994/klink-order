<?php
namespace App\Console\Migration;

use Illuminate\Support\Facades\Artisan;

trait MigrationTrait
{
    /**
     * Set schema.
     *
     * @param string $schema
     */
    
    protected function getValidModules(string $modules)
    {
        $modules = explode(',', $modules);
        
        return  $modules;
    }
    
    protected function runFor(array $modules)
    {
        foreach ($modules as $module) {
            $this->comment("\n".'Module "'.$module.'" :- ');
            $generatedPath = app_path('Modules/'.$module.'/database/migrations');
            if (file_exists(app_path('Modules/'.$module.'/database/migrations'))) {
                $this->makeMigrate($generatedPath);
            } else {
                $this->error($module.' Module Migration  does\'nt exist : '.app_path('Modules/'.$module.'/database/migrations').'/. No Such File Or Direcotry');
            }
        }
    }
}
