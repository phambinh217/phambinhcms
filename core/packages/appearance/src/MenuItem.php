<?php

namespace Packages\Appearance;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Hierarchical;

class MenuItem extends Model
{
    use Filter, Hierarchical;

    protected $table = 'menu_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'url',
        'menu_id',
        'parent_id',
        'object_id',
        'type',
        'icon',
        'css_class',
        'order',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'            => 'integer',
        'title'         => 'max:255',
        'type'          => 'max:255',
        'menu_id'       => 'integer',
        'object_id'     => 'integer',
        'url'           => 'max:255',

        '_orderby'      => 'in:id,title,order,created_at,updated_at',
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
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    public function menu()
    {
        return $this->belongTo('Packages\Appearance\Menu');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
