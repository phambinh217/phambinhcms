<?php

namespace Packages\Cms\Support\Traits;

trait Hierarchical
{
    public function scopeParentAble($query)
    {
        $query->where('id', '!=', $this->id)->where('parent_id', '!=', $this->id);
    }

    public function hasChild()
    {
        return $this->where('parent_id', $this->id)->count() != 0;
    }
}
