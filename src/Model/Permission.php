<?php

namespace kosuha606\VirtualAdmin\Model;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @package kosuha606\VirtualAdmin\Model
 */
class Permission extends VirtualModel
{
    const TYPE = 'permission';

    public static function providerType()
    {
        return self::TYPE;
    }

    public function attributes(): array
    {
        return [
            'id',
            'entity',
            'entity_id',
            'action',
            'user_id',
        ];
    }
}