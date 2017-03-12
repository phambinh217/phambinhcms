<?php

namespace Packages\Deky;

use Illuminate\Database\Eloquent\Builder;
use Packages\Cms\User;

class Student extends User
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => 'integer',
        'name' => '',
        'email' => '',
        'status' =>'in:all,enable,disable',
        'avatar' => '',
        'role_id' => 'integer',
        'phone' => '',
        'last_name' => '',
        'first_name' => '',
        'pivot_created_at' => '',
        'pivot_student_group_id' => '',
        'pivot_user_intro_id' => '',
        'is_intro' => 'in:true,false',
        'class_status' => '',

        '_orderby'      => 'in:id,name,last_name,first_name,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    protected static $defaultFilter = [
        'status'        => 'enable',
        'orderby'       =>  'first_name.asc',
    ];

    protected static $statusIntroAble = [
        ['slug' => 'be-intro', 'name' => 'Được giới thiệu bởi ai đó'],
        ['slug' => 'free', 'name' => 'Tự đăng ký']
    ];

    public function courses()
    {
        return $this->beLongsToMany('Packages\Deky\Course', 'classes')->withPivot('created_at', 'student_group_id', 'user_intro_id', 'id', 'course_id');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (! empty($args['status'])) {
            switch ($args['status']) {
                case 'all':
                    break;

                case 'enable':
                    $query->where('users.status', '1');
                    break;
                
                case 'disable':
                    $query->where('users.status', '0');
                    break;
            }
        }

        if (! empty($args['last_name'])) {
            $query->where('last_name', $args['last_name']);
        }

        if (! empty($args['phone'])) {
            $query->where('phone', $args['phone']);
        }

        if (! empty($args['email'])) {
            $query->where('email', $args['email']);
        }

        if (! empty($args['first_name'])) {
            $query->where('first_name', $args['first_name']);
        }

        if (! empty($args['name'])) {
            $query->where('name', $args['name']);
        }

        if (! empty($args['pivot_student_group_id'])) {
            $query->where('classes.student_group_id', $args['pivot_student_group_id']);
        }

        if (! empty($args['pivot_user_intro_id'])) {
            $query->where('classes.user_intro_id', $args['pivot_user_intro_id']);
        }

        if (! empty($args['is_intro'])) {
            switch ($args['is_intro']) {
                case 'be-intro':
                    $query->where('classes.user_intro_id', '!=', '0');
                    break;
                
                case 'free':
                    $query->where('classes.user_intro_id', '0');
                    break;
            }
        }

        if (! empty($args['class_status'])) {
            switch ($args['class_status']) {
                case 'no-class':
                
                break;
                
                case 'has-class':
                
                break;
            }
        }
    }

    public function hasClass()
    {
        return $this->courses()->count() != 0;
    }

    public static function statusIntroAble()
    {
        return self::$statusIntroAble;
    }

    public function inClass($course_id)
    {
        return \DB::table('classes')->where([
            'student_id'    =>  $this->id,
            'course_id'     =>  $course_id,
        ])->exists();
    }
}
