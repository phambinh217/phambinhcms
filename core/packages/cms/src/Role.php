<?php

namespace Packages\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Packages\Cms\Support\Traits\Filter;

class Role extends Model
{
    use Filter;

    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
    ];

    protected static $filterable = [
        'id'            => 'integer',
        'name'          => 'max:255',
        '_orderby'      => 'in:id,name,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    protected static $defaultFilter = [
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    protected $searchable = ['id', 'name'];

    public function users()
    {
        return $this->hasMany('Packages\Cms\User');
    }

    public function permissions()
    {
        return $this->hasMany('Packages\Cms\Permission');
    }
    
    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function isFull()
    {
        return $this->type == '*';
    }

    public function isEmpty()
    {
        return $this->type == '0';
    }

    public function isOption()
    {
        return $this->type == 'option';
    }

    public function isAdmin()
    {
        if ($this->isEmpty()) {
            return false;
        }
        
        return true;
    }

    public static function typeable()
    {
        return new Collection([
            ['id' => '*', 'name' => 'Có mọi quyền'],
            ['id' => 'option', 'name' => 'Tùy chọn'],
            ['id' => '0', 'name' => 'Cấm tất cả'],
        ]);
    }
}
