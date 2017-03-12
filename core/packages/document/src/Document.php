<?php

namespace Packages\Document;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Illuminate\Database\Eloquent\Builder;
use Packages\Cms\Support\Traits\Thumbnail;
use Packages\Cms\Support\Traits\SEO;

class Document extends Model
{
    use Filter, Thumbnail, SEO;

    protected $table = 'documents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'version_id',
        'author_id',
        'status',
        'thumbnail',
        'created_at',
        'updated_at',
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
        'version_id' => 'integer',

        '_orderby'      => 'in:id,title,version_id,created_at,updated_at',
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
        'orderby'      =>  'updated_at.desc',
    ];

    protected static $statusAble = [
        ['slug' => 'disable', 'name' => 'Xóa tạm'],
        ['slug' => 'enable', 'name' => 'Công khai'],
    ];

    protected static $defaultStatus = 'enable';

    protected $searchable = [
        'documents.id',
        'documents.title',
    ];

    public function version()
    {
        return $this->beLongsTo('Packages\Document\Version');
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

        if (! empty($args['version_id'])) {
            $query->where('version_id', $args['version_id']);
        }
    }

    public static function statusable()->all()
    {
        return self::$statusAble;
    }

    public static function getDefaultStatus()
    {
        return self::$defaultStatus;
    }

    public function isEnable()
    {
        return $this->status == 1;
    }

    public function isDisable()
    {
        return $this->status == 0;
    }

    public function getHtmlClassAttribute()
    {
        if ($this->status == '0') {
            return 'bg-danger';
        }

        return null;
    }

    public function scopeEnable($query)
    {
        return $query->where('status', '1');
    }

    public function scopeDisable($query)
    {
        return $query->where('status', '0');
    }

    public function markAsEnable()
    {
        $this->where('id', $this->id)->update(['status' => '1']);
    }

    public function markAsDisable()
    {
        $this->where('id', $this->id)->update(['status' => '0']);
    }

    public function setStatusAttribute($value)
    {
        switch ($value) {
            case 'disable':
                $this->attributes['status'] = '0';
                break;

            default:
                $this->attributes['status'] = '1';
                break;
        }
    }

    public function getStatusSlugAttribute()
    {
        if (! is_null($this->status)) {
            return $this->statusable()->all()[$this->status]['slug'];
        }

        return $this->getDefaultStatus();
    }

    public function getStatusNameAttribute()
    {
        return $this->statusable()->all()[$this->status]['name'];
    }

    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['slug'] = str_slug($value);
        } else {
            $this->attributes['slug'] = $value;
        }
    }
}
