<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $entity_class
 * @property $url
 * @property $created_at
 */
class SeoUrlVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'url',
            'created_at',
        ];
    }
}