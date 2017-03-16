<?php

namespace Phambinh\Cms\Support\Traits;

trait Slug
{
    public function setSlugAttribute($value)
    {
        if (property_exists($this, 'slugSource')) {
            $slug = $this->slugSource;
        } else {
            $slug = 'title';
        }

        if ($value) {
            $this->attributes['slug'] = $value;
        } else {
            $this->attributes['slug'] = str_slug($this->$slug);
        }
    }
}
