<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @package kosuha606\VirtualAdmin\Domains\Multilang
 */
class StaticTranslationVm extends VirtualModelEntity
{
    use MultilangTrait;

    public function attributes(): array
    {
        return [
            'id',
            'value',
        ];
    }
}