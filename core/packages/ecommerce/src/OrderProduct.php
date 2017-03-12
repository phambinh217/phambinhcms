<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class OrderProduct extends Model
{
    use Filter;

    protected $table = 'order_products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'code',
        'quantity',
        'price',
        'options',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
        'name' => '',
        'code' => '',
        'quantity' => 'integer',
        'price',
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

    protected $casts = [
        'options' => 'array',
    ];
    
    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function options()
    {
        return $this->hasMany('Packages\Ecommerce\OrderProductOption');
    }
}
