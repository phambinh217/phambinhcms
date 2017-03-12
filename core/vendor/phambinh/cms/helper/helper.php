<?php

include __DIR__ .'/constant.php';

if (! function_exists('str_standard')) {
    function str_standard($str)
    {
        $str = mb_strtolower($str, 'utf-8');

        $array_str = explode(chr(32), $str);
        $str_std = null;
        
        foreach ($array_str as $i => $word) {
            if (trim($word) == null) {
                unset($array_str[ $i ]);
            }
        }

        $str = implode(chr(32), $array_str);

        return $str;
    }
}

if (! function_exists('str_keyword')) {
    function str_keyword($str)
    {
        $str = str_standard($str);
        $str = str_replace(chr(32), '%', $str);
        $str = '%'.$str .'%';

        return str_unicode($str);
    }
}

if (!function_exists('json_encode_pretify')) {
    function json_encode_pretify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

if (! function_exists('str_unicode')) {
    function str_unicode($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        
        return $str;
    }
}

if (! function_exists('std_uri')) {
    function std_uri($path)
    {
        if (starts_with($path, url('/'))) {
            $path = str_replace(url('/'), null, $path);
        }

        return trim($path, '/');
    }
}

if (! function_exists('url_in_local')) {
    function url_in_local($url)
    {
        $base_url = url('/');
        $base_url = str_replace(['http://', 'https://'], null, $base_url);
        $base_url = str_replace('/', '\/', $base_url);
        $p = "/(http:\/\/|https:\/\/)" . ($base_url) ."\/(.+)/";

        return preg_match($p, $url) == 1;
    }
}

if (!function_exists('asset_url')) {
    function asset_url($module, $path = null)
    {
        if ($path) {
            $append = trim($module, '/') .'/'.$path;
        } else {
            $append = $module;
        }

        return url('assets/'.$append);
    }
}

if (! function_exists('prefix_number')) {
    function prefix_number($value, $prefix = null)
    {
        if ($prefix == null) {
            if ($value >= 0) {
                return '+' . $value;
            }
            return '-' . $value;
        }
        
        return $prefix . $value;
    }
}

if (! function_exists('mkdirs')) {
    function mkdirs($path)
    {
        $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
        $segments = explode(DIRECTORY_SEPARATOR, $path);
        $p = null;
        foreach ($segments as $segment) {
            if (empty($segment)) {
                continue;
            }

            $p .= $segment . DIRECTORY_SEPARATOR;
            if (! is_dir($p)) {
                mkdir($p);
            }
        }
    }
}

if (! function_exists('changeFormatDate')) {
    function changeFormatDate($date, $currentFormat = DTF_DB, $format = DTF_NORMAL_24)
    {
        $timestamp = dateToTimesamp($date, $currentFormat);
        return date($format, $timestamp);
    }
}

if (! function_exists('dateToTimesamp')) {
    function dateToTimesamp($date, $format = DTF_DB)
    {
        $date = date_parse_from_format($format, $date);
        $timestamp = mktime(
            (int) $date['hour'],
            (int) $date['minute'],
            (int) $date['second'],
            (int) $date['month'],
            (int) $date['day'],
            (int) $date['year']
        );

        return $timestamp;
    }
}

if (! function_exists('get_total_dates')) {
    function get_total_dates($first, $last, $output_format = 'd/m/Y', $step = '+1 day')
    {
        $dates        = [];
        $current    = strtotime($first);
        $last        = strtotime($last);

        while ($current <= $last) {
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
}

if (! function_exists('get_dates')) {
    function get_dates($type)
    {
        switch ($type) {
            case 'this-month':
                $dates = get_total_dates(date('Y-m-01'), date('Y-m-t'), DF_DB);
                break;
        }

        return $dates;
    }
}

if (!function_exists('text_time_difference')) {
    function text_time_difference($date, $format = DTF_DB)
    {
        $time = time() - dateToTimesamp($date, $format);

        $tokens = [
            31536000 => 'năm',
            2592000 => 'tháng',
            604800 => 'tuần',
            86400 => 'ngày',
            3600 => 'giờ',
            60 => 'phút',
            1 => 'giây'
        ];

        if ($time != 0) {
            if ($time < 1) {
                $time = abs($time);
                $subfix = ' nữa';
            } else {
                $subfix = ' trước';
            }

            foreach ($tokens as $unit => $text) {
                if ($time < $unit) {
                    continue;
                }
                $number_of_units = floor($time / $unit);
                return $number_of_units.' '.$text . $subfix;
            }
        } else {
            return 'Vừa xong';
        }
    }
}

if (! function_exists('preg_array_key_exists')) {
    function preg_array_key_exists($pattern, $array)
    {
        foreach ($array as $key => $value) {
            if (preg_match($pattern, $key, $m)) {
                return $m;
            }
        }

        return false;
    }
}
    

if (! function_exists('array_undot')) {
    function array_undot($path, $value, &$arr, $separator = '.')
    {
        $keys = explode($separator, $path);
        foreach ($keys as $key) {
            $arr = &$arr[$key];
        }

        $arr = $value;
        return $arr;
    }
}

if (! function_exists('array_forget_value')) {
    function array_forget_value($array, $value)
    {
        foreach ($array as $key => $val) {
            if ($value == $val) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}

if (!function_exists('array_max')) {
    function array_max($array)
    {
        $max = $array[0];
        foreach ($array as $value) {
            if ($max < $value) {
                $max = $value;
            }
        }
        return $max;
    }
}

if (!function_exists('array_total')) {
    function array_total($array)
    {
        $sum = 0;
        foreach ($array as $value) {
            $sum = $sum + $value;
        }
        return $sum;
    }
}

if (! function_exists('admin_url')) {
    function admin_url($path = null, $parameters = [], $string_query = true, $secure = null)
    {
        if ($string_query) {
            if (count($parameters)) {
                if (str_contains($path, '?')) {
                    $path .= '&';
                } else {
                    $path .= '?';
                }

                $i = 0;
                foreach ($parameters as $key => $value) {
                    if ($i != 0) {
                        $path .= '&';
                    }
                    $path .= $key .'=' . $value;
                    $i++;
                }

                $parameters = [];
            }
        }

        return url('admin/' . $path, $parameters, $secure);
    }
}

if (! function_exists('api_url')) {
    function api_url($path = null, $parameters = [], $secure = null)
    {
        return url('api/' . $path, $parameters, $secure);
    }
}

if (! function_exists('upload_url')) {
    function upload_url($path = null, $parameters = [], $secure = null)
    {
        return url('uploads/' . $path, $parameters, $secure);
    }
}

if (! function_exists('thumbnail_url')) {
    function thumbnail_url($image_url, $size = [])
    {
        // Nếu file không thuộc nội bộ website trả về file gốc
        // không xử lí
        if (! file_in_local($image_url)) {
            return $image_url;
        }

        // Xử lí file ảnh thumnail từ file ảnh gốc
        if (is_string($size)) {
            $size_string = $size;
        } else {
            $size = array_merge(['height' => '100', 'width' => '100'], $size);
            $size_string = implode('x', $size);
        }

        $image_relative_path = urldecode(str_replace(upload_url() .'/', '', $image_url));
        $image_name = basename($image_relative_path);
        $thumbnail_name = $size_string . $image_name;
        $thumbnail_path = str_replace($image_name, null, $image_relative_path);
        
        if (! file_exists(image_path($image_relative_path))) {
            return $image_url;
        }

        mkdirs(image_thumb_path($thumbnail_path));

        // Nếu file ảnh này đã được tạo thì trả về file trước đó
        if (file_exists(image_thumb_path($thumbnail_path . $thumbnail_name))) {
            return image_thumb_url($thumbnail_path . $thumbnail_name);
        }

        // Tạo file ảnh mới
        \Image::make(image_path($image_relative_path))
        ->fit($size['width'], $size['height'], function ($constraint) {
            $constraint->upsize();
        }, 'center')
        ->save(image_thumb_path($thumbnail_path . $thumbnail_name));

        return image_thumb_url($thumbnail_path . $thumbnail_name);
    }
}

if (!function_exists('upload_path')) {
    function upload_path($path = null)
    {
        return config('cms.upload_path').($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (! function_exists('image_path')) {
    function image_path($image = null)
    {
        return upload_path($image);
    }
}

if (! function_exists('image_thumb_path')) {
    function image_thumb_path($image = null)
    {
        return config('cms.thumb_path').($image ? DIRECTORY_SEPARATOR . $image : $image);
    }
}

if (! function_exists('image_thumb_url')) {
    function image_thumb_url($image = null)
    {
        return upload_url('thumbs/' . $image);
    }
}

if (! function_exists('file_in_local')) {
    function file_in_local($file_url)
    {
        $base_url = url('/');
        $base_url = str_replace(['http://', 'https://'], null, $base_url);
        $base_url = str_replace('/', '\/', $base_url);
        
        return preg_match("/(http:\/\/|https:\/\/)". $base_url ."\/uploads\/(.+)/", $file_url) == 1;
    }
}

if (! function_exists('image_url')) {
    function image_url($image = null)
    {
        return upload_url($image);
    }
}

if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app(\Phambinh\Cms\Services\Setting::class);
        }

        return \Setting::get($key, $default);
    }
}

if (!function_exists('add_action')) {
    function add_action($hook, $callback, $priority = 20)
    {
        \Action::addListener($hook, $callback, $priority);
    }
}

if (!function_exists('do_action')) {
    function do_action(...$args)
    {
        \Action::fire(array_shift($args), $args);
    }
}

if (!function_exists('add_filter')) {
    function add_filter($hook, $callback, $priority = 20)
    {
        \Filter::addListener($hook, $callback, $priority);
    }
}

if (!function_exists('do_filter')) {
    function do_filter(...$args)
    {
        return \Filter::fire(array_shift($args), $args);
    }
}

if (! function_exists('package_namespace')) {
    function package_namespace($alias = null, $append = null)
    {
        if ($alias) {
            $alias = '\\'.studly_case($alias);
        }

        if ($append) {
            $append = '\\'.$append;
        }

        return 'Packages' . $alias . $append;
    }
}

if (! function_exists('module_namespace')) {
    function module_namespace($alias = null, $append = null)
    {
        return package_namespace($alias, $append);
    }
}

if (!function_exists('package_path')) {
    function package_path($path = null)
    {
        return base_path('packages'. ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('std_namespace')) {
    function std_namespace($namespace)
    {
        return implode('\\', array_map(function ($segment) {
            return studly_case($segment);
        }, explode('\\', $namespace)));
    }
}

if (!function_exists('addCss')) {
    function addCss($location, $src)
    {
        \Asset::where($location)->addCss($src);
    }
}

if (!function_exists('addJs')) {
    function addJs($location, $src)
    {
        \Asset::where($location)->addJs($src);
    }
}
