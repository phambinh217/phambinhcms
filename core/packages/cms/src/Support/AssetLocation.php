<?php

namespace Packages\Cms\Support;

use Illuminate\Support\Collection;

class AssetLocation
{
    protected $cssFiles;
    
    protected $jsFiles;
    
    protected $filter;

    public function __construct()
    {
        $this->cssFiles = new Collection();
        $this->jsFiles = new Collection();

        $this->setFilter();
    }

    public function addJs($file)
    {
        $this->jsFiles->push($file);

        return $this;
    }

    public function addCss($file)
    {
        $this->cssFiles->push($file);
           
        return $this;
    }

    public function onlyJs()
    {
        $this->filter['css'] = false;
        return $this;
    }

    public function onlyCss()
    {
        $this->filter['js'] = false;
        return $this;
    }

    public function render()
    {
        if (!$this->cssFiles->isEmpty() && $this->filter['css']) {
            $this->cssFiles->unique()->values()->each(function ($item) {
                ?>
                    <link rel="stylesheet" type="text/css" href="<?php echo $item ?>" />
                <?php
            });
        }

        if (!$this->jsFiles->isEmpty() && $this->filter['js']) {
            $this->jsFiles->unique()->values()->each(function ($item) {
                ?>
                    <script type="text/javascript" src="<?php echo $item ?>"></script>
                <?php
            });
        }

        $this->setFilter();
    }

    private function setFilter()
    {
        $this->filter = ['css' => true, 'js' => true];
    }
}
