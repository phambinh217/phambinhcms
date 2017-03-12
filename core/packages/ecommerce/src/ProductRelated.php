<?php

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class ProductRelateds extends Model
{
    use Filter;

    protected $table = 'product_relates';

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'relate_id',
        'order',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'product_id' => 'integer',
        'relate_id' => '',
        'order' => '',
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

    /**
     * Hình ảnh thuộc về một sản phẩm
     * @return [type] [description]
     */
    public function products()
    {
        return $this->beLongsTo('Packages\Ecommerce\Product');
    }

    /**
     * Hình ảnh thuộc về một sản phẩm
     * @return [type] [description]
     */
    public function relates()
    {
        return $this->beLongsTo('Packages\Ecommerce\Product');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }
}
