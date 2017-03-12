<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class OrderProductOption extends Model
{
    use Filter;

    protected $table = 'order_product_options';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_product_id',
        'option_id',
        'value_id',
        'value',
        'order_id',
        'name',
        'price',
        'prefix',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'order_product_id' => 'integer',
        'option_id' => 'integer',
        'value_id' => 'integer',
        'value' => '',
        'order_id' => '',
        'created_at' => '',
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        'orderby'      =>  'id.desc',
    ];

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
