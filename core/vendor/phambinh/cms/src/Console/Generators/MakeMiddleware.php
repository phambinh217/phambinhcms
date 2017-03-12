<?php

namespace Phambinh\Cms\Console\Generators;

use Phambinh\Cms\Support\Abstracts\Generator as AbstractGenerator;

class MakeMiddleware extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:middleware
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Middleware';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/middleware/middleware.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Http\\Middleware\\' . $this->argument('name');
    }
}
