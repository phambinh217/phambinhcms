<?php

namespace Packages\Deky;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;
use Packages\Cms\Support\Traits\Thumbnail;

class Course extends Model
{
    use Filter, Thumbnail;

    protected $table = 'courses';

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
        'price',
        'time_open',
        'time_finish',
        'status',
        'trainer_id',
        'lesson',
        'test',
        'target',
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
        'id'  => 'integer',
        'title' => '',
        'status' => 'in:enable,disable,pending',
        'time_status' => 'in:comming,learning,finished',
        'category_id' => 'integer',
        'author_id' => 'integer',
        'trainer_id' => 'integer',
        'price' => '',
        'time_open' => '',
        'time_finish' => '',

        '_orderby'      => 'in:id,title,price,created_at,updated_at',
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
        'status'        => 'enable',
        'orderby'        =>    'time_open.desc',
    ];

    protected static $statusAble = [
        ['slug' => 'disable', 'name' => 'Ẩn'],
        ['slug' => 'enable', 'name' => 'Công khai'],
        ['slug' => 'pending', 'name' => 'Chờ duyệt'],
    ];

    protected static $timeStatusAble = [
        ['slug'   => 'coming', 'name'  =>  'Sắp khai giảng'],
        ['slug'   => 'finished', 'name'  =>  'Kết thúc'],
        ['slug'   => 'learning', 'name'  =>  'Đang học'],
    ];

    protected $searchable = [
        'courses.id',
        'courses.title',
    ];

    public function categories()
    {
        return $this->beLongsToMany('Packages\Deky\Category', 'course_to_category');
    }

    public function trainer()
    {
        return $this->beLongsTo('Packages\Deky\Trainer');
    }

    public function students()
    {
        return $this->beLongsToMany('Packages\Deky\Student', 'classes')->withPivot('created_at', 'student_group_id', 'user_intro_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany('Packages\Deky\Class1');
    }

    public function usersIntro()
    {
        return $this->beLongsToMany('Packages\Cms\User', 'classes', 'course_id', 'user_intro_id');
    }

    public function isComing()
    {
        $now = time();
        $time_open = dateToTimesamp($this->time_open, DTF_DB);
        return $now < $time_open;
    }

    public function isFinished()
    {
        $now = time();
        $time_finish = dateToTimesamp($this->time_finish, DTF_DB);
        return $now >= $time_finish;
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

                case 'pending':
                    $query->pending();
                    break;
            }
        }

        if (! empty($args['time_open'])) {
            $query->where('time_open', changeFormatDate($args['time_open'], 'd-m-Y', 'Y-m-d'));
        }

        if (! empty($args['time_finish'])) {
            $query->where('time_finish', changeFormatDate($args['time_finish'], 'd-m-Y', 'Y-m-d'));
        }

        if (! empty($args['author_id'])) {
            $query->where('author_id', $args['author_id']);
        }

        if (isset($args['price']) && strlen($args['price'])) {
            $query->where('price', $args['price']);
        }

        if (! empty($args['trainer_id'])) {
            $query->where('trainer_id', $args['trainer_id']);
        }

        if (! empty($args['title'])) {
            $query->where('title', $args['title']);
        }

        if (! empty($args['time_status'])) {
            $args[ $args['time_status']] = true;
        }

        if (! empty($args['coming'])) {
            $query->coming();
        }

        if (! empty($args['finished'])) {
            $query->finished();
        }

        if (! empty($args['learning'])) {
            $query->learning();
        }

        if (! empty($args['category_id'])) {
            $query->join('course_to_category', 'courses.id', '=', 'course_to_category.course_id');
            $query->where('course_to_category.category_id', $args['category_id']);
        }
    }

    public function scopeComing($query)
    {
        $query->where('time_open', '>', date(DF_DB));
    }

    public function scopeLearning($query)
    {
        $query->where('time_open', '<=', date(DF_DB))
            ->where('time_finish', '>=', date(DF_DB));
    }

    public function scopeFinished($query)
    {
         $query->where('time_finish', '<', date(DF_DB));
    }

    public function isEnable()
    {
        $statusCode = $this->status;
        return $statusCode == '1';
    }

    public function isDisable()
    {
        $statusCode = $this->status;
        return $statusCode == '0';
    }

    public function statusHtmlClass()
    {
        if ($this->status == '0') {
            return 'bg-danger';
        }

        return null;
    }

    public static function statusAble()
    {
        return self::$statusAble;
    }

    public static function timeStatusAble()
    {
        return self::$timeStatusAble;
    }

    public function scopeEnable($query)
    {
        return $query->where('courses.status', '1');
    }

    public function scopeDisable($query)
    {
        return $query->where('courses.status', '0');
    }

    public function scopePending($query)
    {
        return $query->where('courses.status', '3');
    }

    public function markAsEnable()
    {
        $this->where('id', $this->id)->update(['status' => '1']);
    }

    public function markAsDisable()
    {
        $this->where('id', $this->id)->update(['status' => '0']);
    }

    public function markAsPending()
    {
        $this->where('id', $this->id)->update(['status' => '3']);
    }
}
