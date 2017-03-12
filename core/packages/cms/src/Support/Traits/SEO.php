<?php

namespace Packages\Cms\Support\Traits;

use Illuminate\Database\Query\Builder;

trait SEO
{
    public function scopeSEO($query)
    {
        \Metatag::set('title', $this->meta_title);
        \Metatag::set('description', $this->meta_description);
        \Metatag::set('keyword', $this->meta_keyword);
    }
}
