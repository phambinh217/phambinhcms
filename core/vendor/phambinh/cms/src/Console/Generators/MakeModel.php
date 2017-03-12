<?php

namespace Phambinh\Cms\Console\Generators;

use Phambinh\Cms\Support\Abstracts\Generator as AbstractGenerator;

class MakeModel extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:model
    	{alias : The alias of the module}
    	{name : The class name}
    	{table : The table name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $nameInput = $this->getNameInput();

        $name = $this->parseName($nameInput);

        $path = $this->getPath($name);

        if ($this->alreadyExists($nameInput)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/models/model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->argument('name');
    }

    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{table}',
        ], [
            $this->argument('table'),
        ], $stub);
    }
}
