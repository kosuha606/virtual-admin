<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Domains\Cookie\CookieProviderInterface;
use kosuha606\VirtualModel\VirtualModelProvider;

class TestCookieProvider extends VirtualModelProvider implements CookieProviderInterface
{
    public $cookies = [];

    public function type()
    {
        return CookieProviderInterface::class;
    }

    public function get($modelClass, $key)
    {
        return $this->cookies[$key] ?? null;
    }

    public function set($modelClass, $key, $value, $expires = 3600)
    {
        $this->cookies[$key] = $value;
    }
}