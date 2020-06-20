<?php

namespace kosuha606\VirtualAdmin\Domains\Design;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $name
 * @property $widget_class
 *
 */
class WidgetVm extends VirtualModel
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