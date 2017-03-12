<?php

namespace Phambinh\Cms\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeModule extends Command
{
    /**
     * @var string
     */
    protected $signature = 'module:create 
        {alias : The alias of the module}
    ';

    /**
     * @var string
     */
    protected $description = 'Packages modules generator.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container = [];

    /**
     * Accepted module types
     * @var array
     */
    protected $acceptedTypes = [
        'module' => 'Module',
        'theme' => 'Theme',
    ];

    /**
     * Module type
     * @var [type]
     */
    protected $moduleType;

    /**
     * Folder name
     * @var [type]
     */
    protected $moduleFolderName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->moduleType = $this->ask('Your module type. Eccepted: module, theme. Other types will return "theme".', 'theme');
        if (!in_array($this->moduleType, array_keys($this->acceptedTypes))) {
            $this->moduleType = 'theme';
        }

        $this->container['alias'] = str_slug($this->argument('alias'));
        $this->step1();
    }

    private function step1()
    {
        $this->moduleFolderName         = str_slug($this->container['alias']);
        $this->container['name']        = $this->ask('Name of module:', $this->container['alias']);
        $this->container['author']      = $this->ask('Author of module:', 'noname');
        $this->container['description'] = $this->ask('Description of module:', $this->container['name']);
        $this->container['version']     = $this->ask('Module version.', '1.0');
        $this->container['autoload']    = $this->ask('Autoloading type.', 'psr-4');

        $this->step2();
    }

    private function step2()
    {
        $this->generatingModule();

        $this->info("\nYour module generated successfully.");
    }

    private function generatingModule()
    {
        $directory = package_path($this->moduleFolderName);

        $source = __DIR__ . '/../../../resources/stubs/_folder-structure';

        /**
         * Make directory
         */
        $this->files->makeDirectory($directory);
        $this->files->copyDirectory($source, $directory, null);

        /**
         * Replace files placeholder
         */
        $files = $this->files->allFiles($directory);

        foreach ($files as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $filePath = package_path($this->moduleFolderName . '/' . $file->getRelativePathname());

            $this->files->put($filePath, $contents);
        }

        /**
         * Modify the module.json information
         */
        \File::put($directory . '/'. strtolower($this->moduleType) .'.json', json_encode_pretify($this->container));
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyNamespace',
            'DummyAlias',
            'DummyUcfirst',
            'DummyName',
            'DummyAuthor',
            'DummyVersion',
        ];

        $replace = [
            module_namespace($this->moduleFolderName),
            $this->container['alias'],
            $this->moduleFolderName,
            $this->container['name'],
            $this->container['author'],
            $this->container['version'],
        ];

        return str_replace($find, $replace, $contents);
    }
}
