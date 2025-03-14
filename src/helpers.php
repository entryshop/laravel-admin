<?php

use Entryshop\Admin\Admin;

if (!function_exists('admin')) {
    function admin()
    {
        return app(Admin::class);
    }
}

if (!function_exists('render')) {
    function render($renderable, ...$args)
    {
        if (is_string($renderable)) {
            return $renderable;
        }

        if (is_numeric($renderable)) {
            return (string)$renderable;
        }

        if (is_null($renderable)) {
            return '';
        }

        if (is_bool($renderable)) {
            return $renderable ? 'true' : 'false';
        }

        if (is_array($renderable)) {
            $result = '';
            foreach ($renderable as $item) {
                $result .= render($item, ...$args);
            }

            return $result;
        }

        if ($renderable instanceof Closure) {
            $renderable = evaluate($renderable, ...$args);
            return render($renderable, ...$args);
        }

        if (empty($renderable)) {
            return '';
        }

        if (method_exists($renderable, 'render')) {
            if (is_array($args[0] ?? null) && method_exists($renderable, 'set')) {
                $renderable->set($args[0]);
            }
            return $renderable->render();
        }

        return (string)$renderable;
    }
}

if (!function_exists('resolve_class')) {
    function resolve_class($contact_class)
    {
        return get_class(resolve($contact_class));
    }
}

if (!function_exists('evaluate')) {
    function evaluate($value, ...$context)
    {
        if ($value instanceof Closure) {
            return call_user_func($value, ...$context);
        }
        return $value;
    }
}

if (!function_exists('to_json')) {
    function to_json($string)
    {
        if ('string' === gettype($string)) {
            return json_decode($string, true);
        }
        return $string;
    }
}

if (!function_exists('to_string')) {
    function to_string($string)
    {
        try {
            if (is_string($string)) {
                return $string;
            }

            if (is_numeric($string)) {
                return (string)$string;
            }

            if (is_bool($string)) {
                return $string ? 'true' : 'false';
            }

            if (is_array($string) || is_object($string)) {
                return json_encode($string, JSON_PRETTY_PRINT);
            }

            if (empty($string)) {
                return '';
            }

            return $string->__toString();
        } catch (Exception $e) {
            return 'error to parse';
        }
    }
}

if (!function_exists('interpolate')) {
    function interpolate($template = null, $data = [])
    {
        if (empty($template)) {
            return to_string($template);
        }
        return preg_replace_callback('/\{([\w\.]+(?:\([\w\.\s,]*\))?)\}/', function ($matches) use ($data, $template) {
            $allowedFunctions = [
                'mb_strtolower',
                'mb_strtoupper',
                'time',
                'bcadd',
                'bcmod',
                'bcsub',
                'bcdiv',
                'bcmul',
                'bcsqrt',
                'bcpow',
                'intval',
                'strval',
                'floatval',
                'date',
            ];
            $expression       = $matches[1];

            // 匹配函数调用
            if (preg_match('/^(\w+)\(([\w\.\s,]*)\)$/', $expression, $funcMatches)) {
                $function = $funcMatches[1];

                // 检查函数是否在白名单中
                if (!in_array($function, $allowedFunctions)) {
                    return $matches[0]; // 如果函数不在白名单中，保留原始占位符
                }

                if (!empty($funcMatches[2])) {
                    $arguments = array_map('trim', explode(',', $funcMatches[2]));
                    foreach ($arguments as &$arg) {
                        $keys  = explode('.', $arg);
                        $value = $data;

                        foreach ($keys as $key) {
                            if (empty($key)) {
                                continue;
                            }
                            if (is_array($value) && isset($value[$key])) {
                                $value = $value[$key];
                            } elseif (is_object($value) && isset($value->{$key})) {
                                $value = $value->{$key};
                            } else {
                                $value = $key; // 如果找不到对应的值，则保留原始占位符
                            }
                        }
                        $arg = $value;
                    }
                } else {
                    $arguments = [];
                }

                // 执行白名单内的函数
                if (function_exists($function)) {
                    return call_user_func_array($function, $arguments);
                }

                return $matches[0]; // 如果函数不存在，则保留原始占位符
            }

            // 非函数调用的占位符处理
            return data_get($data, $expression) ?? $template;
        }, $template);
    }
}

if (!function_exists('interpolate_recursive')) {
    function interpolate_recursive($input = [], $data = [])
    {
        if (empty($data) || empty($input)) {
            return $input;
        }
        array_walk_recursive($input, function (&$value) use ($data) {
            if (is_string($value) && preg_match('/\{[^}]+\}/', $value)) {
                $value = data_get($data, trim($value, '{}'));
            }
        });
        return $input;
    }
}

if (!function_exists('to_attributes')) {
    /**
     * Convert array to attributes
     * @param $array
     * @return string
     *
     * @example  ['foo'=>'bar', 'x'=>'y'] to 'foo="bar" x="y"'
     */
    function to_attributes($array)
    {
        return collect($array)->map(function ($value, $key) {
            if (empty($key)) {
                return $value;
            }
            return $key . '="' . $value . '"';
        })->implode(' ');
    }
}

if (!function_exists('class_from_contract')) {
    function class_from_contract($contract)
    {
        return get_class(app($contract));
    }
}
