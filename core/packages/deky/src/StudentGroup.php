<?php

namespace Packages\Deky;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Illuminate\Database\Eloquent\Builder;

class StudentGroup extends Model
{
    use Filter;

    protected $table = 'student_groups';

    protected $primaryKey = 'id';

    public function students()
    {
        return $this->beLongsToMany('Packages\Deky\Student', 'classes');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
