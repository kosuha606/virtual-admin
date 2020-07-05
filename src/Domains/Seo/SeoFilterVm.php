<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $type
 * @property $value
 * @property $slug
 * @property $order
 *
 */
class SeoFilterVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'type',
            'value',
            'slug',
            'order',
        ];
    }
}