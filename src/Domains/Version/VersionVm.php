<?php

namespace kosuha606\VirtualAdmin\Domains\Version;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $entity_class
 * @property $attributes
 * @property $created_at
 * @property $disable_restore
 *
 */
class VersionVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'attributes',
            'created_at',
            'disable_restore'
        ];
    }

    public function attributesData()
    {
        return json_decode($this->attributes['attributes'], true);
    }
}