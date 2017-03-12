<?php

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Thumbnail;

class Tag extends Model
{
    use Filter, Thumbnail;

    protected $table = 'shop_tags';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'icon',
        'order',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'name' => '',
        'slug' => '',
        'meta_title' => '',
        'meta_description' => '',
        'thumbnail' => '',
        'icon' => '',
        'parent_id' => '',
        'order' => '',
        'created_at' => '',

        '_orderby'      => 'in:id,name,order,created_at,updated_at',
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
        'orderby'      =>  'id.desc',
    ];

    /**
     * Danh mục có nhiều sản phẩm
     * @return [type] [description]
     */
    public function products()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_to_tag');
    }
    
    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
