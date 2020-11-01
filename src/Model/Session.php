<?php

namespace kosuha606\VirtualAdmin\Model;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @property $key
 * @property $value
 */
class Session extends VirtualModelEntity
{
    const TYPE = 'session';

    /**
     * @return string
     */
    public static function providerType()
    {
        return self::TYPE;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id',
            'key',
            'value',
        ];
    }
}
