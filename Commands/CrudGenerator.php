<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate
                            {name : Class (singular) for example User}
                            {--controller=true : whether want to use controller or not, use true or false}
                            {--model=true : whether want to use model or not, use true or false}
                            {--migration=true : whether want to use migration or not, use true or false use true or false}
                            {--route=false : Routing auto write}
                            {--view=true : whether want to use view or not, use true or false}
                            {--migrate=false : whether directly refresh the tables in DB}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path('stubs/' . $type . '.stub'));
    }

    protected function toSnakeCase($name)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $name, $matches);

        $ret = $matches[0];
        
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        
        return implode('_', $ret);
    }

    protected function model($name)
    {
        $modelTemplate = str_replace([
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $this->toSnakeCase(str_plural($name)),
                $this->toSnakeCase($name)
            ],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $this->toSnakeCase(str_plural($name)),
                $this->toSnakeCase($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    protected function migration($name)
    {
        $migrationTable = $this->toSnakeCase(str_plural($name));

        return Artisan::call("make:migration create_{$migrationTable}_table");
    }

    protected function view($name)
    {
        $indexTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $this->toSnakeCase(str_plural($name)),
                $this->toSnakeCase($name)
            ],
            $this->getStub('Views/index')
        );

        $createTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $this->toSnakeCase(str_plural($name)),
                $this->toSnakeCase($name)
            ],
            $this->getStub('Views/create')
        );

        $editTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $this->toSnakeCase(str_plural($name)),
                $this->toSnakeCase($name)
            ],
            $this->getStub('Views/edit')
        );

        $showTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $this->toSnakeCase(str_plural($name)),
                $this->toSnakeCase($name)
            ],
            $this->getStub('Views/show')
        );

        $folderName = $this->toSnakeCase(str_plural($name));
        if (!file_exists(base_path() . "/resources/views/{$folderName}")) {
            mkdir(base_path() . "/resources/views/{$folderName}", 0777, true);
        }

        file_put_contents(base_path() . "/resources/views/{$folderName}/index.blade.php", $indexTemplate);
        file_put_contents(base_path() . "/resources/views/{$folderName}/create.blade.php", $createTemplate);
        file_put_contents(base_path() . "/resources/views/{$folderName}/edit.blade.php", $editTemplate);
        file_put_contents(base_path() . "/resources/views/{$folderName}/show.blade.php", $showTemplate);
    }

    protected function route($name)
    {
        $controllerName = $name . 'Controller';
        $uri = $this->toSnakeCase(str_plural($name));

        $newRoute = "\nRoute::resource('/$uri', '$controllerName');";

        $routeFile = base_path() . '/routes/web.php';

        file_put_contents($routeFile, $newRoute, FILE_APPEND);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        if($this->option('controller') == 'true')
            $this->controller($name);

        if($this->option('model') == 'true')
            $this->model($name);

        if($this->option('migration') == 'true')
            $this->migration($name);

        if($this->option('view') == 'true')
            $this->view($name);

        if($this->option('route') == 'true')
            $this->route($name);

        if($this->option('migrate') == 'true')
            Artisan::call('migrate:refresh', [
                '--seed' => 'default'
            ]);
    }
}
