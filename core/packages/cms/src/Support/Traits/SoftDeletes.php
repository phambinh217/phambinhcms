<?php

namespace Packages\Cms\Support\Traits;

use Illuminate\Support\Collection;

trait SoftDeletes
{
    public static function statusable()->all()
    {
        return new Collection([
            ['name' => 'Tắt', 'slug' => 'disable'],
            ['name' => 'Bật', 'slug' => 'enable'],
        ]);
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

    public function getHtmlClassAttribute()
    {
        if ($this->status == '0') {
            return 'bg-danger';
        }

        return null;
    }
}
