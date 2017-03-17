<?php

namespace Phambinh\CmsInstall\Services;

class EnvReader
{
    protected $env;
    protected $path;

    public function __construct()
    {
        $this->path = base_path('.env');
        $contents = preg_split("/(\n|\r|PHP_EOL)/", file_get_contents($this->path));

        foreach ($contents as $i => $row) {
            if (trim($row) != '') {
                $key_value = explode('=', $row);
                list($key, $value) = $key_value;
                $this->env[$key] = $value;
            } else {
                $this->env[$i] = "\n";
            }
        }
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function setEnv($key, $value)
    {
        $this->env[$key] = $value;
        return $this;
    }

    public function write()
    {
        $env_string = null;
        foreach ($this->env as $key => $value) {
            if (is_numeric($key)) {
                $env_string .= "\n";
            } else {
                $env_string .= "$key=$value"."\n";
            }
        }

        file_put_contents($this->path, $env_string);
    }
}
