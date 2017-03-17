<?php

namespace Phambinh\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Phambinh\Cms\Support\ElfinderConnector;

class ElfinderController extends AdminController
{
    public function index()
    {
        \Metatag::set('title', trans('file.list-file'));
        return view('Cms::admin.file.list', $this->data);
    }

    public function standAlone()
    {
        return view('Cms::admin.file.stand-alone', $this->data);
    }

    public function connector()
    {
        $roots = config('cms.roots', []);

        if (empty($roots)) {
            $dirs = (array) config('cms.upload_path', [public_path('storage')]);

            if (!is_dir($dirs[0])) {
                mkdir($dirs[0], 0777, true);
            }

            foreach ($dirs as $dir) {
                $path = $dir;
                $url = basename($dir);
                $roots[] = [
                    'driver'    => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path'      =>  $path, // path to files (REQUIRED)
                    'tmpPath'   =>  $path,
                    'URL'       => url($url), // URL to files (REQUIRED)
                    'accessControl' => 'Phambinh\Cms\Http\Controllers\ElfinderController::checkAccess', // filter callback (OPTIONAL),
                    'autoload' => true,
                    'uploadDeny' => ['text/x-php', 'application/x-shockwave-flash'],
                    'uploadAllow' => [],
                    'uploadOrder' => ['deny', 'allow'],
                    'uploadOverwrite' => false,
                    'attributes' => [
                        [
                            'pattern' => '/\.(txt|html|php|py|pl|sh|xml|php|sh)$/i',
                            'read' => true,
                            'write' => false,
                            'locked' => false,
                            'hidden' => false
                        ]
                    ]
                ];
            }

            $disks = (array) config('file.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }

                $disk = app('filesystem')->disk($key);
                if ($disk instanceof \Illuminate\Filesystem\FilesystemAdapter) {
                    $defaults = [
                        'driver'       => 'Flysystem',
                        'filesystem'   => $disk->getDriver(),
                        'alias'        => $key,
                    ];
                    $roots[] = array_merge($defaults, $root);
                }
            }
        }

        $opts = ['roots' => $roots, 'debug' => true];

        $connector = new ElfinderConnector(new \elFinder($opts));
        $connector->run();
        
        return $connector->getResponse();
    }

    public static function checkAccess($attr, $path, $data, $volume)
    {
        return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
            ? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
            : null;                                    // else elFinder decide it itself
    }
}
