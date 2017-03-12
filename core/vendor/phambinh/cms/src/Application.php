<?php

namespace Phambinh\Cms;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return realpath($this->basePath.'/..');
    }
}
