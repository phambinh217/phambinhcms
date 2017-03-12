<?php

namespace Packages\Appearance;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Slug;

class Menu extends Model
{
    use Slug;

    protected $table = 'menus';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'location',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'        => 'integer',
        'name'      => 'max:255',
        'slug'      => 'max:255',
        'location'  => 'max:255',

        '_orderby'      => 'in:id,name,created_at,updated_at',
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
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    public function items()
    {
        return $this->hasMany('Packages\Appearance\MenuItem');
    }

    public function location($key = null)
    {
        $location = \Menu::locationWhere('id', $this->location)->first();
        if (!empty($key)) {
            $location = $location[$key];
        }

        return $location;
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function scopeUpdateStruct($query, $menu_items, $parent_id = '0', $order = '0')
    {
        foreach ($menu_items as $menu_item) {
            if (isset($menu_item['children'])) {
                $query->updateStruct($menu_item['children'], $menu_item['id']);
            }

            $this->items()->where('id', $menu_item['id'])->update([
                'parent_id' => $parent_id,
                'order'     => $order,
            ]);

            $order++;
        }
    }
}
