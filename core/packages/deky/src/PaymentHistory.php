<?php

namespace Packages\Deky;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class PaymentHistory extends Model
{
    use Filter;

    protected $table = 'payment_histories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'class_id',
        'comment',
        'collecter_id',

        '_orderby'      => 'in:id,class_id,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];
}
