<?php

namespace Packages\Cms\Services;

use Packages\Cms\Setting as DbSetting;

class Setting
{
    protected $prefix = 'setting.';

    public function sync($key, $value)
    {
        if (str_contains($key, '.')) {
            $keys = explode('.', $key);
            $key_item = array_shift($keys);
            $key = implode('.', $keys);

            if ($values = $this->getValue($key_item)) {
                array_set($values, $key, $value);
                $this->setValue($key_item, $values);
                return array_get($values, $key);
            }
        }

        $this->setValue($key, $value);
        return $value;
    }

    public function get($key, $default = null)
    {
        if (str_contains($key, '.')) {
            $keys = explode('.', $key);
            if ($total_value = $this->getValue(array_shift($keys))) {
                $value = array_get($total_value, implode('.', $keys));
            }
        } else {
            $value = $this->getValue($key, $default);
        }

        return $value ? $value : $default;
    }

    private function setValue($key_item, $value)
    {
        if (env('INSTALLED')) {
            $setting = DbSetting::firstOrCreate(['key' => $key_item]);
            $setting->fill(['value' => $value])->save();
            
            \Cache::forever($this->prefix.$key_item, json_encode($value));
        }
    }

    private function getValue($key_item, $default = null)
    {
        if (env('INSTALLED')) {
            $key_item = $key_item;

            if (\Cache::has($this->prefix.$key_item)) {
                $value = json_decode(\Cache::get($this->prefix.$key_item), true);
                return $value;
            } elseif ($setting = DbSetting::where(['key' => $key_item])->first()) {
                \Cache::forever($this->prefix.$key_item, json_encode($setting->value));
                return $setting->value;
            }

            return $default;
        }
    }
}
