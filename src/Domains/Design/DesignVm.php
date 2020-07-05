<?php

namespace kosuha606\VirtualAdmin\Domains\Design;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @property $priority
 * @property $template
 */
class DesignVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'route',
            'priority',
            'template',
        ];
    }

}