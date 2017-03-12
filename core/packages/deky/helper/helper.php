<?php 
/**
 * ModuleAlias: course
 * ModuleName: course
 * Description: Helper functions of module course
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

if (! function_exists('ref_url')) {
    function ref_url($url = '')
    {
        // Nếu đã bao gồm tham số ref rồi
        if (str_contains($url, '?ref=') || str_contains($url, '&ref=')) {
            return url($url);
        }

        $ref_code = ref_code();

        if ($ref_code) {
            if (str_contains($url, '?')) {
                $url .= '&ref=' . $ref_code;
            } else {
                $url .= '?ref=' . $ref_code;
            }
        }

        return url($url);
    }
}

if (!function_exists('ref_route')) {
    function ref_route($name, $params = [], $absolute = true)
    {
        if ($ref_code = ref_code()) {
            $params = array_merge($params, ['ref' => $ref_code]);
        }
        return route($name, $params, $absolute);
    }
}


if (! function_exists('ref_code')) {
    function ref_code()
    {
        $ref = Request::get('ref');
        if ($ref) {
            $user = Packages\Cms\User::find($ref);
            if ($user) {
                return $user->id;
            }
        }

        return null;
    }
}

if (! function_exists('ref_field')) {
    function ref_field($name = 'ref')
    {
        if (ref_code()) {
            return '<input type="hidden" name="'. $name .'" value="'. ref_code() .'" />';
        }
    }
}

if (! function_exists('my_ref_code_url')) {
    function my_ref_code_url($url = '')
    {
        $ref_code = \Auth::user()->id;
        if ($ref_code) {
            if (str_contains($url, '?')) {
                $url .= '&ref=' . $ref_code;
            } else {
                $url .= '?ref=' . $ref_code;
            }
        }
        
        return url($url);
    }
}

