<?php

namespace kosuha606\VirtualAdmin\Domains\Cookie;

interface CookieProviderInterface
{
    public function get($modelClass, $key);

    public function set($modelClass, $key, $value, $expires = 3600);
}