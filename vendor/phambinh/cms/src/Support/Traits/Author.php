<?php

namespace Phambinh\Cms\Support\Traits;

trait Author
{
    public function setAuthorAttribute($value)
    {
        $author = 'author_id';

        if ($value) {
            $this->attributes[$author] = $value;
        } else {
            if (\Auth::check()) {
                $this->attributes[$author] = \Auth::user()->id;
            }
        }
    }
}
