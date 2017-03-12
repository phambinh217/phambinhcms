<?php

namespace Packages\Deky;

use Packages\Cms\User as CmsUser;

class User extends CmsUser
{
    public function courses()
    {
        return $this->beLongsToMany('Packages\Deky\Course', 'classes', 'user_intro_id')->withPivot('id', 'created_at', 'course_id');
    }

    public function students()
    {
        return $this->beLongsToMany('Packages\Deky\Student', 'classes', 'user_intro_id')->withPivot('id', 'created_at', 'course_id', 'student_group_id');
    }
}
