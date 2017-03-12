<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class Attribute extends Model
{
    use Filter;

    protected $table = 'attributes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
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
        'icon' => '',
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
        '_orderby'      =>  'id',
        '_sort'         =>  'desc',
    ];

    /**
     * Danh mục có nhiều sản phẩm
     * @return [type] [description]
     */
    public function products()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_to_attribute');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
