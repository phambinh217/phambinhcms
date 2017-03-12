<?php

namespace Packages\Cms\Support\Traits;

trait Slug
{
    protected $slugSource = 'title';

    public function setSlugAttribute($value)
    {
        $slug = 'slug';
        if ($value) {
            $this->attributes[$slug] = $value;
        } else {
            $this->attributes[$slug] = str_slug($this->{$this->slugSource});
        }
    }
}
