<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class OrderDetail extends Model
{
    use Filter;

    protected $table = 'order_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'code',
        'name',
        'value',
        'sort',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'order_id' => 'integer',
        'code' => '',
        'name' => '',
        'value' => '',
        'sort' => '',
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
