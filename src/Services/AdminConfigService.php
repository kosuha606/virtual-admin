<?php

namespace kosuha606\VirtualAdmin\Services;

class AdminConfigService
{
    /**
     * @param $a
     * @param $b
     * @return array|mixed
     */
    public static function merge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            foreach (array_shift($args) as $k => $v) {
                if (is_int($k)) {
                    if (array_key_exists($k, $res)) {
                        $res[] = $v;
                    } else {
                        $res[$k] = $v;
                    }
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    /**
     * @param $dir
     * @return array|mixed
     */
    public function loadConfigs($dir)
    {
        $files = glob("$dir/*.php");
        $config = [];

        foreach ($files as $file) {
            $fileConfig = require($file);
            $config = self::merge($config, $fileConfig);
        }

        return $config;
    }
}
