<?php

namespace kosuha606\VirtualAdmin\Domains\Design;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $name
 * @property $widget_class
 *
 */
class WidgetVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'widget_class',
        ];
    }

}