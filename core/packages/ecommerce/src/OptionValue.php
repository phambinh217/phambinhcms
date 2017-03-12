<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class OptionValue extends Model
{
    use Filter;

    protected $table = 'option_values';

    protected $primaryKey = 'id';

    protected $fillable = [
        'option_id',
        'value',
        'image',
        'order',
        'type',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'  => 'integer',
        'option_id' => 'integer',
        'value' => '',
        'image' => '',
        'order' => '',
        'type' => '',
        
        '_orderby'      => 'in:id,value,type,order,created_at,updated_at',
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
     * Giá thị thuộc về một tùy chọn
     * @return [type] [description]
     */
    public function option()
    {
        return $this->beLongsTo('Packages\Ecommerce\Option');
    }

    public function products()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_to_option_value', 'value_id', 'product_id')->withPivot('prefix', 'price', 'subtract', 'quantity', 'id');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
