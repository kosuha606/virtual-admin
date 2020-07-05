<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $from_url
 * @property $to_url
 *
 */
class SeoRedirectVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'from_url',
            'to_url',
        ];
    }
}