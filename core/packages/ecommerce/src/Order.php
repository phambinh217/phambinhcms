<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\FullName;
use Packages\Cms\Support\Traits\Avatar;

class Order extends Model
{
    use Filter, FullName, Avatar;

    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'comment',
        'total',
        'currency_id',
        'currency_code',
        'currency_value',
        'status_id',
        'options',
        'confirm_token',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'customer_id' => 'integer',
        'first_name' => '',
        'last_name' => '',
        'email' => 'email',
        'phone' => '',
        'address' => '',
        'comment' => '',
        'total' => '',
        'currency_id' => 'integer',
        'currency_code' => '',
        'currency_value' => '',
        'status_id' => 'integer',
        'created_at' => '',
        'confirm_token' => '',

        '_orderby'      => 'in:id,first_name,last_name,email,phone,total,order,created_at,updated_at',
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

    public function customer()
    {
        return $this->beLongsTo('Packages\Cms\User');
    }

    public function currency()
    {
        return $this->beLongsTo('Packages\Ecommerce\Currency');
    }

    public function status()
    {
        return $this->beLongsTo('Packages\Ecommerce\OrderStatus');
    }

    public function products()
    {
        return $this->hasMany('Packages\Ecommerce\OrderProduct');
    }

    public function details()
    {
        return $this->hasMany('Packages\Ecommerce\OrderDetail');
    }

    public function productOptions()
    {
        return $this->hasMany('Packages\Ecommerce\OrderProductOption');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function scopeNoConfirm($query)
    {
        $query->where('orders.status_id', setting('order-status-not-confirm'));
    }

    public function scopeConfirm($query)
    {
        $query->where('orders.status_id', '!=', setting('order-status-not-confirm'));
    }

    public function markAsConfirm($token)
    {
        if ($this->where(['id' => $this->id, 'confirm_token' => $token])->exists()) {
            $this->where(['id' => $this->id, 'confirm_token' => $token])->update([
                'status_id' => setting('default-order-status-id'),
            ]);
            return true;
        }

        return false;
    }
}

