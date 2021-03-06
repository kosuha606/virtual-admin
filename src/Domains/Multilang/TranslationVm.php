<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $entity_class
 * @property $lang_id
 * @property $attribute
 * @property $data
 *
 */
class TranslationVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'lang_id',
            'attribute',
            'data',
        ];
    }
}