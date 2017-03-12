<?php

namespace Packages\Cms;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class Permission extends Model
{
    public $timestamps = false;

    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'permission',
    ];

    public function role()
    {
        return $this->beLongsTo('Packages\Cms\Role');
    }
}
