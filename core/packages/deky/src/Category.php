<?php

namespace Packages\Deky;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Thumbnail;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use Filter, Thumbnail;
    
    protected $table = 'course_categories';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    protected static $filterable = [
        'id'            => 'integer',
        'title'         => 'max:255',
        'parent_id'     => 'integer',
        '_orderby'      => 'in:id,title,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    protected static $defaultFilter = [
        'orderby'       => 'id.desc',
    ];

    public function courses()
    {
        return $this->beLongsToMany('Packages\Deky\Course', 'course_to_category');
    }

    /*
     * Truy vấn nhân viên
     *
     * @param
     * @return
     * @author BinhPham
     */
    public function scopeApplyFilter($query, $args = [])
    {   
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
