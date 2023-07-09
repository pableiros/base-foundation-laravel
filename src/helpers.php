<?php

if (! function_exists('dd5')) {
    function dd5($values)
    {
        http_response_code(500);
        dd($values);
    }
}

if (! function_exists('get_opt_value')) {
    function get_opt_value($values, $key, $default = null)
    {
        $value = null;

        if (isset($values[$key])) {
            $value = $values[$key];
        } else if ($default !== null) {
            $value = $default;
        }

        return $value;
    }
}

if (! function_exists('sum_collection')) {
    function sum_collection($values, $key, $column)
    {
        $result = 0;

        if (isset($values[$key])) {
            $result = collect($values[$key])->sum(function ($content) use ($column) {
                return $content[$column];
            });
        }

        return $result;
    }
}

if (! function_exists('is_per_page_set')) {
    function is_per_page_set($values)
    {
        return isset($values['per_page']) && is_numeric($values['per_page']);
    }
}
