<?php

namespace kosuha606\VirtualAdmin\Domains\Menu;

use kosuha606\VirtualAdmin\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModelEntity;

class MenuItemVm extends VirtualModelEntity
{
    use MultilangTrait;

    public function attributes(): array
    {
        return [
            'id',
            'link',
            'label',
            'menu_id',
            'order',
        ];
    }
}