<?php

namespace Phambinh\Cms;

use App\User as AppUser;
use Carbon\Carbon;
use Phambinh\Cms\Support\Traits\Filter;
use Phambinh\Cms\Support\Traits\Status;
use Phambinh\Cms\Support\Traits\FullName;
use Phambinh\Cms\Support\Traits\Avatar;

class User extends AppUser
{
    use Filter, Status, FullName, Avatar;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $dates = ['birth'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role_id',
        'last_name',
        'first_name',
        'birth',
        'phone',
        'avatar',
        'address',
        'website',
        'facebook',
        'google_plus',
        'about',
        'job',
        'api_token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $searchable = ['id', 'name', 'email', 'phone', 'last_name', 'first_name'];

    protected static $filterable = [
        'id'            => 'integer',
        'name'          => 'max:255',
        'email'         => 'email',
        'status'        => 'in:enable,disable',
        'role_id'       => 'integer',
        'phone'         => 'max:255',
        'last_name'     => 'max:255',
        'first_name'    => 'max:255',
        
        '_orderby'      => 'in:id,name,email,phone,last_name,first_name,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_keyword'      => 'max:255',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
    ];

    protected static $defaultFilter = [
        'status'        => 'enable',
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    public function role()
    {
        return $this->beLongsTo('Phambinh\Cms\Role');
    }

    public function inbox()
    {
        return $this->hasMany('Phambinh\Cms\Mail', 'receiver_id');
    }

    public function outbox()
    {
        return $this->hasMany('Phambinh\Cms\Mail', 'sender_id');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        
        $query->baseFilter($args);

        foreach ($args as $key => $value) {
            if ($key == 'status') {
                switch ($value) {
                    case 'enable':
                        $query->enable();
                        break;

                    case 'disable':
                        $query->disable();
                        break;
                }
            } elseif (!in_array($key, ['_orderby', '_sort', '_limit', '_offset', '_keyword'])) {
                $query->where($key, $value);
            }
        }
    }

    public function isSelf()
    {
        if (! \Auth::check()) {
            return false;
        }

        return \Auth::user()->id == $this->id;
    }

    public function setBirthAttribute($value)
    {
        $this->attributes['birth'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
}
