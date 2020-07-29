<?php

namespace kosuha606\VirtualAdmin\Domains\Cookie;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * getRaw - метод возвращает данные куки напрямую без фреймворка
 * get - возвращает куки которые ставил фреймворк
 * set - устанавливает куки средствами фреймворка
 *
 * @method static get($key);
 * @method static getRaw($key);
 * @method static set($key, $value, $expires);
 */
class CookieVm extends VirtualModelEntity
{
    public static function providerType()
    {
        return CookieProviderInterface::class;
    }
}