<?php

namespace Phambinh\Cms\Services;

use Illuminate\Support\Collection;

class Language
{
    protected $languages;

    public function __construct()
    {
        $this->languages = new Collection();
        $languageDirs = scandir(resource_path('lang'));
        foreach ($languageDirs as $dir) {
            if ($dir != '.' && $dir != '..') {
                $this->languages->push($dir);
            }
        }
    }

    public function rules()
    {
        return 'in:' . $this->implode(',');
    }

    public function __call($method, $params)
    {
        if (! method_exists($this, $method)) {
            return call_user_func_array([$this->languages, $method], $params);
        }
    }
}
