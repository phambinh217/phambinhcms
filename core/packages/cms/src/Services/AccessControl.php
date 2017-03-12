<?php

namespace Packages\Cms\Services;

use Packages\Cms\Role;
use Packages\Cms\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Collection;

class AccessControl
{
    /**
     * Lưu tất cả các permission
     * @var array
     */
    public $permissions = [];

    /**
     * Lưu các vai trò
     * @var array
     */
    public $roles = [];
    
    private $cachePrefix = 'acl.';

    public function __construct(Permission $permission, Role $role)
    {
        $this->permissions = new Collection();

        if (! \Cache::has($this->cachePrefix.'role')) {
            $this->roles = new Collection();
            if (env('INSTALLED')) {
                $roles = $role->with('permissions')->get();

                foreach ($roles as $role_item) {
                    if ($role_item->isFull()) {
                        $this->roles->push([
                            'id' => $role_item->id,
                            'name' => $role_item->name,
                            'permissions' => '*',
                        ]);
                    } elseif ($role_item->isEmpty()) {
                        $this->roles->push([
                            'id' => $role_item->id,
                            'name' => $role_item->name,
                            'permissions' => false,
                        ]);
                    } else {
                        $this->roles->push([
                            'id' => $role_item->id,
                            'name' => $role_item->name,
                            'permissions' => $role_item->permissions->pluck('permission')->toArray(),
                        ]);
                    }
                }

                \Cache::forever($this->cachePrefix.'role', $this->roles);
            }   
        } else {
            $this->roles = new Collection(\Cache::get($this->cachePrefix.'role'));
        }
    }

    public function getRole($role_id)
    {
        return $this->roles->where('id', $role_id)->first();
    }

    public function define($name, $ability, $callback = null)
    {
        if (! $callback) {
            $self = $this;
            $callback = function ($user) use ($self, $ability) {
                return $self->baseCheck($user, $ability);
            };
        }

        $this->permissions->push([
            'name' => $name,
            'ability' => $ability,
            'callback' => $callback,
        ]);

        return Gate::define($ability, $callback);
    }

    private function baseCheck($user, $ability)
    {
        if ($this->getRole($user->role_id)['permissions'] == '*') {
            return true;
        }

        if ($this->getRole($user->role_id)['permissions'] == false) {
            return false;
        }

        return in_array($ability, $this->getRole($user->role_id)['permissions']);
    }

    public function forgetCache()
    {
        \Cache::forget($this->cachePrefix.'role');
    }

    public function __call($method, $params)
    {
        if (! method_exists($this, $method)) {
            return call_user_func_array([$this->permissions, $method], $params);
        }
    }
}
