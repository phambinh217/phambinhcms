<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class OrderStatus extends Model
{
    use Filter;

    protected $table = 'order_statuses';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'comment',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'name' => '',
        'comment' => '',
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

    public function orders()
    {
        return $this->hasMany('Packages\Ecommerce\Order', 'status_id');
    }
}
