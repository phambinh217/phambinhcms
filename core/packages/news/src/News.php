<?php

namespace Packages\News;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\SEO;
use Packages\Cms\Support\Traits\Hierarchical;
use Packages\Cms\Support\Traits\Author;
use Packages\Cms\Support\Traits\Status;
use Packages\Cms\Support\Traits\Slug;

class News extends Model
{
    use Filter, Thumbnail, SEO, Author, Hierarchical, Status, Slug;
    
    protected $table = 'newses';

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
        'id' => '',
        'title' => '',
        'status' => 'in:pending,enable,disable',
        'time_status' => 'in:coming,enable,disable',
        'category_id' => 'integer',
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        'status'            => 'enable',
        '_orderby'          => 'updated_at',
        '_sort'             => 'desc',
    ];

    protected $searchable = ['id', 'title'];

    public function categories()
    {
        return $this->beLongsToMany('Packages\News\Category', 'news_to_category');
    }

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

        if (! empty($args['category_id'])) {
            $query->join('news_to_category', 'newses.id', '=', 'news_to_category.news_id');
            $query->where('news_to_category.category_id', $args['category_id']);
        }
    }

    public function getSubContentAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->content)) {
            return str_limit(strip_tags($this->content), 150);
        }

        return null;
    }
}
