<?php 

namespace Packages\Cms\Services;

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

    public function registerFromJsonFile($id, $path)
    {
        $filename = basename($path);
        if (starts_with($filename, 'theme')) {
            $type = 'theme';
        } else {
            $type = 'module';
        }

        if (\File::exists($path)) {
            $info = json_decode(\File::get($path));
            $path = realpath($path);
            $info->file = $path;
            $info->type = $type;
            $parent_dirname = dirname($path);
            
            if (\File::exists($parent_dirname .'/icon.png')) {
                $info->icon = url(str_replace([public_path(), $type.'.json', DIRECTORY_SEPARATOR], [null, null, '/'], $path) .'icon.png');
            } else {
                $info->icon = upload_url('no-icon.png');
            }

            $this->modules->push(new ModuleItem($info));
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

    public function checkUpdate()
    {
        if (! $this->isVersionControl()) {
            return false;
        }

        $key = 'module-'. $this->alias.'-sha-comit';
        if (! $setting = \DB::table('settings')->where('key', $key)->first()) {
            return true;
        } else {
            $repo = $this->getRepoCommit(['since' => changeFormatDate($setting->updated_at, DTF_DB, 'Y-m-d\TH:i:s\Z')]);

            if (! $repo->first()) {
                return false;
            }

            $sha = $repo->first()->sha;

            return $sha != $setting->value;
        }
    }

    public function markAsUpdated()
    {
        $sha = $this->repo->first()->sha;
        setting()->sync('module-'. $this->alias.'-sha-comit', $sha);
    }

    public function isVersionControl()
    {
        return isset($this->github_repo);
    }

    public function getRepoCommit($params = [])
    {
        if (property_exists($this, 'github_repo')) {
            $res = \Curl::to('https://api.github.com/repos/'.$this->github_repo.'/commits')
                ->withData($params)
                ->withOption('USERAGENT', 'spider')
                ->asJson()
                ->get();

            return $this->repo = collect($res);
        }

        return null;
    }
}
