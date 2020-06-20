<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $id
 * @property $code
 * @property $name
 * @property $is_default
 *
 */
class LangVm extends VirtualModel
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