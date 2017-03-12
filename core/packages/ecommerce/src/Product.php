<?php

namespace Packages\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\Status;

class Product extends Model
{
    use Filter, Thumbnail, Status;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'author_id',
        'status',
        'thumbnail',
        'shipping',
        'subtract',
        'quantity',
        'price',
        'promotional_price',
        'available_at',
        'code',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'  => 'integer',
        'name' => '',
        'slug' => '',
        'content' => '',
        'meta_title' => '',
        'meta_description' => '',
        'author_id' => 'integer',
        'status' => 'in:enable,disable',
        'thumbnail' => '',
        'shipping' => '',
        'subtract' => 'in:true,false',
        'quantity' => 'integer',
        'price' => '',
        'promotional_price' => '',
        'available_at' => '',
        'created_at' => '',
        'category_id' => '',
        'brand_id' => '',
        'tag_id' => '',
        'filter_id' => '',
        'sale' => 'in:true,false',
        'code' => '',
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        'orderby'      =>  'id.desc',
        'status' => 'enable',
    ];

    /**
     * Quản lí kho hàng
     * @var array
     */
    protected static $subtractAble = [
        ['slug' => 'false', 'name' => 'Không'],
        ['slug' => 'true', 'name' => 'Có'],
    ];

    /**
     * Quản lí kho hàng
     * @var array
     */
    protected static $saleAble = [
        ['slug' => 'false', 'name' => 'Không'],
        ['slug' => 'true', 'name' => 'Có'],
    ];

    protected $searchable = [
        'products.id',
        'products.name',
        'products.code',
    ];

    /**
     * Sản phẩm được đăng bởi một tác giả
     * @return [type] [description]
     */
    public function author()
    {
        return $this->beLongsTo('Packages\User');
    }

    /**
     * Sản phẩm thuộc nhiều danh mục
     * @return [type] [description]
     */
    public function categories()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Category', 'product_to_category');
    }

    /**
     * Sản phẩm thuộc nhiều thương hiệu
     * @return [type] [description]
     */
    public function brands()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Brand', 'product_to_brand');
    }

    /**
     * Sản phẩm thuộc nhiều bộ lọc
     * @return [type] [description]
     */
    public function filters()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Filter', 'product_to_filter');
    }

    /**
     * Sản phẩm có nhiều thuộc tính
     * @return [type] [description]
     */
    public function attributes()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Attribute', 'product_to_attribute')->withPivot('value', 'order');
    }

    /**
     * Sản phẩm có nhiều sản phẩm liên quan
     * @return [type] [description]
     */
    public function relates()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Product', 'product_relates', 'relate_id');
    }

    /**
     * Sản phẩm có nhiều tùy chọn
     * @return [type] [description]
     */
    public function options()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Option', 'product_to_option')->withPivot('required', 'value', 'type');
    }

    /**
     * Sản phẩm có nhiều giá trị cho tùy chọn
     * @return [type] [description]
     */
    public function optionValues()
    {
        return $this->beLongsToMany('Packages\Ecommerce\OptionValue', 'product_to_option_value', 'product_id', 'value_id')->withPivot('prefix', 'price', 'subtract', 'quantity', 'id');
    }

    /**
     * Sản phẩm có nhiều tags
     * @return [type] [description]
     */
    public function tags()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Tag', 'product_to_tag');
    }

    /**
     * Sản phẩm có nhiều khách hàng
     * @return [type] [description]
     */
    public function customers()
    {
        return $this->beLongsToMany('Packages\Ecommerce\Order', 'orders', 'customer_id');
    }

    /**
     * Sản phẩm có nhiều hình ảnh
     * @return [type] [description]
     */
    public function images()
    {
        return $this->hasMany('Packages\Ecommerce\ProductImage', 'product_id');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (!empty($args['status'])) {
            switch ($args['status']) {
                case 'enable':
                    $query->enable();
                    break;
                
                case 'disable':
                    $query->disable();
                    break;
            }
        }

        if (!empty($args['author_id'])) {
            $query->where('author_id', $args['author_id']);
        }

        if (!empty($args['code'])) {
            $query->where('code', $args['code']);
        }

        if (!empty($args['name'])) {
            $query->where('name', $args['name']);
        }

        if (!empty($args['subtract'])) {
            switch ($args['subtract']) {
                case 'true':
                    $query->where('subtract', '1');
                    break;

                case 'false':
                    $query->where('subtract', '0');
                    break;
            }
        }

        if (!empty($args['sale'])) {
            switch ($args['sale']) {
                case 'true':
                    $query->where('promotional_price', '!=', '0');
                    break;

                case 'false':
                    $query->where('promotional_price', '0');
                    break;
            }
        }

        if (!empty($args['category_id'])) {
            $query->join('product_to_category', 'products.id', '=', 'product_to_category.product_id');
            if (is_array($args['category_id'])) {
                $query->whereIn('product_to_category.category_id', $args['category_id']);
            } else {
                $query->where('product_to_category.category_id', $args['category_id']);
            }
        }

        if (!empty($args['brand_id'])) {
            $query->join('product_to_brand', 'products.id', '=', 'product_to_brand.product_id');
            if (is_array($args['brand_id'])) {
                $query->whereIn('product_to_brand.brand_id', $args['brand_id']);
            } else {
                $query->where('product_to_brand.brand_id', $args['brand_id']);
            }
        }

        if (!empty($args['filter_id'])) {
            $query->join('product_to_filter', 'products.id', '=', 'product_to_filter.product_id');
            if (is_array($args['filter_id'])) {
                $query->whereIn('product_to_filter.filter_id', $args['filter_id']);
            } else {
                $query->where('product_to_filter.filter_id', $args['filter_id']);
            }
        }

        if (!empty($args['tag_id'])) {
            $query->join('product_to_tag', 'products.id', '=', 'product_to_tag.product_id');
            if (is_array($args['tag_id'])) {
                $query->whereIn('product_to_tag.tag_id', $args['tag_id']);
            } else {
                $query->where('product_to_tag.tag_id', $args['tag_id']);
            }
        }

        if (!empty($args['price'])) {
            // price = less:, greater, between:
            if (starts_with($args['price'], 'less:')) {
                $price = mb_substr($args['price'], strpos($args['price'], ':') + 1);
                $query->where('price', '<', $price);
            } elseif (starts_with($args['price'], 'greater:')) {
                $price = mb_substr($args['price'], strpos($args['price'], ':') + 1);
                $query->where('price', '>', $price);
            } elseif (starts_with($args['price'], 'less_equal:')) {
                $price = mb_substr($args['price'], strpos($args['price'], ':') + 1);
                $query->where('price', '<', $price);
            } elseif (starts_with($args['price'], 'greater_equal:')) {
                $price = mb_substr($args['price'], strpos($args['price'], ':') + 1);
                $query->where('price', '>=', $price);
            } elseif (starts_with($args['price'], 'between:')) {
                $price = explode(',', mb_substr($args['price'], strpos($args['price'], ':') + 1));
                if (count($price) == 2) {
                    $query->whereBetween('price', $price);
                }
            } else {
                $query->where('price', $args['price']);
            }
        }

        if (!empty($args['quantity'])) {
            // quantity = less:, greater, between:
            if (starts_with($args['quantity'], 'less:')) {
                $quantity = mb_substr($args['quantity'], strpos($args['quantity'], ':') + 1);
                $query->where('quantity', '<', $quantity);
            } elseif (starts_with($args['quantity'], 'greater:')) {
                $quantity = mb_substr($args['quantity'], strpos($args['quantity'], ':') + 1);
                $query->where('quantity', '>', $quantity);
            } elseif (starts_with($args['quantity'], 'less_equal:')) {
                $quantity = mb_substr($args['quantity'], strpos($args['quantity'], ':') + 1);
                $query->where('quantity', '<', $quantity);
            } elseif (starts_with($args['quantity'], 'greater_equal:')) {
                $quantity = mb_substr($args['quantity'], strpos($args['quantity'], ':') + 1);
                $query->where('quantity', '>=', $quantity);
            } elseif (starts_with($args['quantity'], 'between:')) {
                $quantity = explode(',', mb_substr($args['quantity'], strpos($args['quantity'], ':') + 1));
                if (count($quantity) == 2) {
                    $query->whereBetween('quantity', $quantity);
                }
            } else {
                $query->where('quantity', $args['quantity']);
            }
        }
    }

    /**
     * Sản phẩm có phải là khuyễn mãi
     * @return boolean
     */
    public function isSale()
    {
        return $this->promotional_price != 0;
    }

    /**
     * Kiểm tra sản phẩm còn hay hết hàng
     * @return boolean
     */
    public function inStock()
    {
        if ($this->isSubtract() && $this->stock == 0) {
            return false;
        }
        
        return true;
    }

    /**
     * Kiểm tra sản phẩm có đang trong trạng thái quản lí kho
     * tự động trừ khi có người mua sản phẩm
     * @return boolean
     */
    public function isSubtract()
    {
        return $this->subtract == 1;
    }

    /**
     * Kiểm tra sản phẩm này có tùy chọn bắt buộc hay không
     * @return boolean [description]
     */
    public function hasOptionRequired()
    {
        return $this->optionRequired()->exists();
    }

    public function optionRequired()
    {
        return \DB::table('product_to_option')->where('product_id', $this->id)->where('required', '1');
    }

    /**
     * Tính toán giá của sản phẩm
     * @param  array $options [description]
     * @return number
     */
    public function calPrice($product_option_values = [])
    {
        // Tính toán dựa vào giá khuyễn mãi
        if ($this->isSale()) {
            $price = $this->promotional_price;
        } else {
            $price = $this->price;
        }

        // Tính toán dựa vào giá trị thuộc tính sản phẩm
        if (count($product_option_values)) {
            $options = \DB::table('product_to_option_value')
                ->select('id', 'price', 'option_id', 'value_id')
                ->whereIn('option_id', array_keys($product_option_values))
                ->where('product_id', $this->id)
                ->get();
            

            foreach ($options as $option_item) {
                if (is_array($product_option_values[$option_item->option_id])) {
                    if (in_array($option_item->value_id, $product_option_values[$option_item->option_id])) {
                        $price = $price + $option_item->price;
                    }
                } elseif ($option_item->value_id == $product_option_values[$option_item->option_id]) {
                    $price = $price + $option_item->price;
                }
            }
        }

        return $price;
    }

    public static function getSubtractAble()
    {
        return self::$subtractAble;
    }

    public static function getSaleAble()
    {
        return self::$saleAble;
    }

    public function statusHtmlClass()
    {
        if (isset($this->statusAble[$this->status]['html_class'])) {
            return $this->statusAble[$this->status]['html_class'];
        }

        return null;
    }
}
