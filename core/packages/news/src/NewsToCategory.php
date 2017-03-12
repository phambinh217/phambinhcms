<?php

namespace Packages\News;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class NewsToCategory extends Model
{
    protected $table = 'news_to_category';

    protected $primaryKey = 'id';

    protected $fillable = [
        'news_id',
        'category_id',
    ];
}
