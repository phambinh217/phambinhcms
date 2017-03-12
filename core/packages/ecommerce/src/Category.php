<?php

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Appearance\Support\Traits\NavigationMenu;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\Hierarchical;

class Category extends Model
{
    use Filter, NavigationMenu, Thumbnail;

    protected $table = 'shop_categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'thumbnail',
        'icon',
        'parent_id',
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

    public function getMenuUrlAttribute()
    {
        return route('product.category', ['slug' => $this->slug, 'id' => $this->id]);
    }

    public function getMenuTitleAttribute()
    {
        return $this->name;
    }

    /**
     * Danh mục có nhiều sản phẩm
     * @return [type] [description]
     */
    public function products()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_to_category');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (isset($args['parent_id'])) {
            $query->where('parent_id', $args['parent_id']);
        }
    }
}
