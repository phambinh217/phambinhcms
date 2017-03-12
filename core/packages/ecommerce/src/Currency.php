<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class Currency extends Model
{
    use Filter;

    protected $table = 'currencies';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'code',
        'symbol_left',
        'symbol_right',
        'decimal_place',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'name' => '',
        'code' => '',
        'symbol_left' => '',
        'symbol_right' => '',
        'decimal_place' => '',
        'value' => '',
        'status' => '',
        
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

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
