<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @package kosuha606\VirtualAdmin\Domains\Multilang
 */
class StaticTranslationVm extends VirtualModel
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