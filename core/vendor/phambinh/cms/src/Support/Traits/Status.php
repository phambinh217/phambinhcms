<?php

namespace Phambinh\Cms\Support\Traits;

use Illuminate\Support\Collection;

trait Status
{
    protected static $defaultStatus = 'enable';

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

            case 'enable':
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

    public static function statusable()
    {
        return new Collection([
            ['id' => '0', 'name' => trans('cms.disable'), 'slug' => 'disable'],
            ['id' => '1', 'name' => trans('cms.enable'), 'slug' => 'enable'],
        ]);
    }

    public static function getDefaultStatus()
    {
        return 'enable';
    }

    public function getHtmlClassAttribute()
    {
        if ($this->status == '0') {
            return 'bg-danger';
        }

        return null;
    }

    public function isEnable()
    {
        return $this->status == 1;
    }

    public function isDisable()
    {
        return $this->status == 0;
    }
}
