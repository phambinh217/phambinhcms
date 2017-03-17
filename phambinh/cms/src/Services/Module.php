<?php 

namespace Phambinh\Cms\Services;

/**
 * Class Quản lí tất cả các module
 */
class Module
{
    /**
     * Đối tượng module
     * @var array
     */
    protected $modules;

    public function __construct()
    {
        $this->modules = collect();
    }

    public function registerFromComposerJson($moduleBasePath)
    {
        $moduleBasePath = trim(realpath($moduleBasePath), '/') . DIRECTORY_SEPARATOR;
        $composerFilePath = $moduleBasePath .'composer.json';

        if (\File::exists($composerFilePath)) {
            $moduleInfo = json_decode(\File::get($composerFilePath), true);
            if (isset($moduleInfo['extra']['phambinhcms-module'])) {
                $moduleInfo = array_merge($moduleInfo, $moduleInfo['extra']['phambinhcms-module']);

                if (isset($moduleInfo['extra']['phambinhcms-module']['type'])) {
                    $moduleInfo['type'] = $moduleInfo['extra']['phambinhcms-module']['type'];
                } else {
                    $moduleInfo['type'] = 'module';
                }

                $moduleInfo['file'] = $composerFilePath;
                
                if (\File::exists($moduleBasePath.'icon.png')) {
                    $moduleInfo['icon'] = url(str_replace([base_path(), DIRECTORY_SEPARATOR], [null, '/'], $moduleBasePath) .'icon.png');
                } else {
                    $moduleInfo['icon'] = upload_url('no-icon.png');
                }

                $this->modules->push(new ModuleItem($moduleInfo));
            }
        }
    }

    /**
     * Gọi các phương thức trang collection
     * @param  string $method
     * @param  array $params
     * @return collection()
     */
    public function __call($method, $params)
    {
        if (! method_exists($this, $method)) {
            return call_user_func_array([$this->modules, $method], $params);
        }
    }
}

class ModuleItem
{
    public function __construct($data)
    {
        $this->repo = collect();
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }
}
