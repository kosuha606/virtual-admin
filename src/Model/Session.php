<?php

namespace kosuha606\VirtualAdmin\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @property $key
 * @property $value
 */
class Session extends VirtualModel
{
    const TYPE = 'session';

    public static function providerType()
    {
        return self::TYPE;
    }

    public function attributes(): array
    {
        return [
            'id',
            'key',
            'value',
        ];
    }
}