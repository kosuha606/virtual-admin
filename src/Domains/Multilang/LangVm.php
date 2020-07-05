<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $code
 * @property $name
 * @property $is_default
 *
 */
class LangVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'code',
            'name',
            'is_default',
        ];
    }
}