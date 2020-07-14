<?php

namespace kosuha606\VirtualAdmin\Domains\Cookie;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @method static get($key);
 * @method static set($key, $value, $expires);
 */
class CookieVm extends VirtualModelEntity
{
    public static function providerType()
    {
        return CookieProviderInterface::class;
    }
}