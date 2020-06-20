<?php

namespace kosuha606\VirtualAdmin\Domains\Design;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @property $priority
 * @property $template
 */
class DesignVm extends VirtualModel
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