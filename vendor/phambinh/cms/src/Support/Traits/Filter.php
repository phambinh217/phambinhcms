<?php

namespace Phambinh\Cms\Support\Traits;

use Illuminate\Support\Facades\Input;
use Validator;

trait Filter
{
    public static function getRequestFilter($defaultFilter = [])
    {
        $filter = array_merge(self::$defaultFilter, $defaultFilter, Input::all());

        $validator = Validator::make($filter, self::$filterable);

        $fieldErros = [];
        if ($validator->fails()) {
            $fieldErros = array_keys($validator->errors()->toArray());
        }

        foreach ($filter as $field => $value) {
            if (! isset(self::$filterable[$field]) || in_array($field, $fieldErros) && ! isset(self::$defaultFilter[$field])) {
                unset($filter[$field]);
            } elseif (in_array($field, $fieldErros) && isset(self::$defaultFilter[$field])) {
                $filter[$field] = self::$defaultFilter[$field];
            }
        }
        
        return array_map('trim', $filter);
    }

    public function scopeSearch($query, $keyword)
    {
        $keyword = str_keyword($keyword);
        foreach ($this->searchable as $index => $field) {
            if ($index == 0) {
                $query->where($this->table.'.'.$field, 'like', $keyword);
            } else {
                $query->orWhere($this->table.'.'.$field, 'like', $keyword);
            }
        }
    }

    public function scopeBaseFilter($query, $args = [])
    {
        if (isset($args[$this->primaryKey])) {
            $query->where($this->table.'.'.$this->primaryKey, $args[$this->primaryKey]);
        }

        if (! empty($args['_orderby']) && ! empty($args['_sort'])) {
            $query->orderBy($args['_orderby'], $args['_sort']);
        }

        if (! empty($args['_limit'])) {
            $query->limit($args['_limit']);
        }

        if (! empty($args['_offset'])) {
            $query->offset($args['_offset']);
        }

        if (! empty($args['_keyword']) && property_exists($this, 'searchable')) {
            $query->search($args['_keyword']);
        }
    }

    public static function scopeLinkSort($query, $text, $fieldOrder)
    {
        $filter = self::getRequestFilter();
        $url = \Request::fullUrlWithQuery(['_orderby' => $fieldOrder, '_sort' => 'desc' ]);

        return '<a href="'. $url .'">'. $text .'</a>';
    }
}
