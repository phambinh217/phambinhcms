<?php

namespace Packages\News;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Appearance\Support\Traits\NavigationMenu;
use Packages\Cms\Support\Traits\Thumbnail;
use Illuminate\Database\Eloquent\Builder;
use Packages\Cms\Support\Traits\SEO;
use Packages\Cms\Support\Traits\Hierarchical;
use Packages\Cms\Support\Traits\Slug;

class Category extends Model
{
    use Filter, NavigationMenu, Thumbnail, SEO, Hierarchical, Slug;

    protected $table = 'news_categories';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    protected static $filterable = [
        'id'  => 'integer',
        'name' => 'max:255',

        '_orderby'      => 'in:id,name,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    protected static $defaultFilter = [
        '_orderby'          => 'updated_at',
        '_sort'             => 'desc',
    ];

    protected $searchable = ['id', 'name', 'meta_keyword'];

    public function newses()
    {
        return $this->beLongsToMany('Packages\News\News', 'news_to_category');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

    public function getMenuUrlAttribute()
    {
        if (\Route::has('news.category')) {
            return route('news.category', ['slug' => $this->slug, 'id' => $this->id]);
        }
        return url($this->slug);
    }

    public function getMenuTitleAttribute()
    {
        return $this->name;
    }
}
