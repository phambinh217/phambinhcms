<?php

namespace Packages\Page;

use Illuminate\Database\Eloquent\Model;
use Packages\Appearance\Support\Traits\NavigationMenu;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Status;
use Packages\Cms\Support\Traits\Slug;
use Packages\Cms\Support\Traits\Author;
use Packages\Cms\Support\Traits\Hierarchical;

class Page extends Model
{
    use Filter, NavigationMenu, Thumbnail, Status, Slug, Author, Hierarchical;
    
    protected $table = 'pages';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'sub_content',
        'author_id',
        'status',
        'thumbnail',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'            => 'integer',
        'title'         => 'max:255',
        'status'        => 'in:enable,disable',
        'author_id'     => 'integer',
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        'status'        => 'enable',
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    protected $searchable = ['id', 'title', 'content', 'meta_keyword'];

    public function author()
    {
        return $this->beLongsTo('Packages\Cms\User');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (! empty($args['status'])) {
            switch ($args['status']) {
                case 'enable':
                    $query->enable();
                    break;
                
                case 'disable':
                    $query->disable();
                    break;
            }
        }

        if (! empty($args['author_id'])) {
            $query->where('author_id', $args['author_id']);
        }

        if (! empty($args['title'])) {
            $query->where('title', $args['title']);
        }
    }

    public function getMenuUrlAttribute()
    {
        if (\Route::has('page.show')) {
            return route('page.show', ['slug' => $this->slug, 'id' => $this->id]);
        }
        return url($this->slug);
    }

    public function getMenuTitleAttribute()
    {
        return $this->title;
    }
}
