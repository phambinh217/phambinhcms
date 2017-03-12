<?php

namespace Packages\Deky;

use Illuminate\Database\Eloquent\Model;
use Packages\Cms\Support\Traits\Filter;

class Class1 extends Model
{
    use Filter;

    protected $table = 'classes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'course_id',
        'student_id',
        'user_intro_id',
        'student_group_id',
        'value_require',
        'comment',
    ];

    /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'            => 'integer',
        'student_id'    => 'integer',
        'course_id'     => 'integer',

        '_orderby'      => 'in:id,student_id,course_id,created_at,updated_at',
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
        'orderby'        =>    'created_at.desc',
    ];


    public function course()
    {
        return $this->beLongsTo('Packages\Deky\Course');
    }

    public function user_intro()
    {
        return $this->beLongsTo('Packages\Cms\User');
    }

    public function student()
    {
        return $this->beLongsTo('Packages\Deky\Student');
    }

    public function group()
    {
        return $this->beLongsTo('Packages\Deky\StudentGroup', 'student_group_id');
    }

    public function payment_histories()
    {
        return $this->hasMany('Packages\Deky\PaymentHistory', 'class_id');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
   
        $joinStudent = false;
        $joinCourse = false;

        if (! empty($args['trainer_id'])) {
            $query->where('trainer_id', $args['trainer_id']);
        }

        if (! empty($args['course_id'])) {
            $query->where('course_id', $args['course_id']);
        }

        if (! empty($args['student_id'])) {
            $query->where('student_id', $args['student_id']);
        }

        if (! empty($args['user_intro_id'])) {
            $query->where('user_intro_id', $args['user_intro_id']);
        }

        if (! empty($args['student_group_id'])) {
            $query->where('student_group_id', $args['student_group_id']);
        }

        if (! empty($args['first_name'])) {
            $joinStudent = true;
            if (! $joinStudent) {
                $query->join('users', 'users.id', 'classes.student_id');
            }

            $query->where('users.first_name', $args['first_name']);
        }

        if (! empty($args['last_name'])) {
            $joinStudent = true;
            if (! $joinStudent) {
                $query->join('users', 'users.id', 'classes.student_id');
            }

            $query->where('users.last_name', $args['last_name']);
        }

        if (! empty($args['phone'])) {
            $joinStudent = true;
            if (! $joinStudent) {
                $query->join('users', 'users.id', 'classes.student_id');
            }

            $query->where('users.phone', $args['phone']);
        }

        if (! empty($args['email'])) {
            $joinStudent = true;
            if (! $joinStudent) {
                $query->join('users', 'users.id', 'classes.student_id');
            }

            $query->where('users.email', $args['email']);
        }
    }

    public static function findByCouse($course_id)
    {
        return self::where('course_id', '=', $course_id)->get();
    }
}
