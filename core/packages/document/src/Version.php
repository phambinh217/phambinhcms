<?php

namespace Packages\Document;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Illuminate\Database\Eloquent\Builder;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\SEO;

class Version extends Model
{
    use Filter, Thumbnail, SEO;

    protected $table = 'document_versions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'created_at',
        'updated_at',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'            => 'integer',
        '_orderby'      => 'in:id,name,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        'orderby'      =>  'updated_at.desc',
    ];

    public function documents()
    {
        return $this->hasMany('Packages\Document\Document');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $query->baseQuery($query, $args);
    }
}
