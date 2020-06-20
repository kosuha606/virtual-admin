<?php

namespace kosuha606\VirtualAdmin\Domains\Menu;

use kosuha606\VirtualAdmin\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;

class MenuItemVm extends VirtualModel
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