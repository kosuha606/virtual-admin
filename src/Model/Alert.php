<?php

namespace kosuha606\VirtualAdmin\Model;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @property $type
 * @property $message
 */
class Alert extends VirtualModelEntity
{
    /**
     * @return string
     */
    public static function providerType()
    {
        return 'system_alert';
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'type',
            'message',
        ];
    }
}
