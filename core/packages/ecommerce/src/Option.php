<?php 

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class Option extends Model
{
    use Filter;

    protected $table = 'options';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
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
        'type' => 'in:select,checkbox,radio,text,textarea',
        'order' => '',
        
        '_orderby'      => 'in:id,name,type,order,created_at,updated_at',
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

    protected $typeAble = [
        ['id' => 'select', 'name' => 'Select', 'type' => 'chose'],
        ['id' => 'checkbox', 'name' => 'Checkbox', 'type' => 'chose'],
        ['id' => 'radio', 'name' => 'Radio', 'type' => 'chose'],
        ['id' => 'text', 'name' => 'Text', 'type' => 'input'],
        ['id' => 'textarea', 'name' => 'Textarea', 'type' => 'input'],
    ];

    /**
     * Danh mục có nhiều sản phẩm
     * @return [type] [description]
     */
    public function products()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_to_option');
    }
    
    /**
     * Tùy chọn có nhiều giá trị
     * @return [type] [description]
     */
    public function values()
    {
        return $this->hasMany('Packages\Ecommerce\OptionValue', 'option_id');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function hasManyValues()
    {
        $hasManyValues = ['select', 'checkbox', 'radio'];
        return in_array($this->type, $hasManyValues);
    }

    /**
     * Kiểm tra tùy chọn có phải là bắt buộc
     * Sử dụng đối với trường hợp model Product join sang bảng option
     * và tồn tại pivot required
     * @return boolean [description]
     */
    public function isRequired()
    {
        return $this->pivot->required == 1;
    }

    public function getTypeAble()
    {
        return collect($this->typeAble);
    }
}
