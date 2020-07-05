<?php

namespace kosuha606\VirtualAdmin\Domains\Design;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $design_id
 * @property $widget_id
 * @property $position
 * @property $order
 * @property $config
 *
 */
class DesignWidgetVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'design_id',
            'widget_id',
            'position',
            'order',
            'config',
        ];
    }

}