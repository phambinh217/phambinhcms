<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Appearance\Support\Traits\NavigationMenu;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\Hierarchical;

class Filter extends Model
{
    use Filter, NavigationMenu, Thumbnail, Hierarchical;

    protected $table = 'filters';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
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

    /**
     * Danh mục có nhiều sản phẩm
     * @return [type] [description]
     */
    public function products()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_to_filter');
    }
    
    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function getMenuUrlAttribute()
    {
        return route('product.filter', ['slug' => $this->slug, 'id' => $this->id]);
    }

    public function getMenuTitleAttribute()
    {
        return $this->name;
    }
}
