<?php

namespace kosuha606\VirtualAdmin\Model;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @property $id
 * @property $entity
 * @property $entity_id
 * @property $action
 * @property $user_id
 */
class Permission extends VirtualModelEntity
{
    const TYPE = 'permission';

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
            'entity',
            'entity_id',
            'action',
            'user_id',
        ];
    }
}
