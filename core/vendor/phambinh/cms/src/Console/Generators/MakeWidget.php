<?php

namespace Phambinh\Cms\Console\Generators;

use Phambinh\Cms\Support\Abstracts\Generator as AbstractGenerator;

class MakeWidget extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:widget
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Widget';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/widget/widget.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Widgets\\' . $this->argument('name');
    }
}
