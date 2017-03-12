<?php

namespace Packages\Cms;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class Setting extends Model
{
    protected $table = 'settings';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'key',
        'value',
        '_orderby'      => 'in:key,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    protected static $defaultFilter = [
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    protected $casts = [
        'value' => 'array',
    ];
}
