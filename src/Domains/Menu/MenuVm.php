<?php

namespace kosuha606\VirtualAdmin\Domains\Menu;

use kosuha606\VirtualAdmin\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

class MenuVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'code',
        ];
    }

    /**
     * @return MenuItemVm[]
     * @throws \Exception
     */
    public function getItems()
    {
        $items = VirtualModelManager::getEntity(MenuItemVm::class)::many([
            'where' => [['=', 'menu_id', $this->id]],
            'orderBy' => ['order' => SORT_ASC]
        ]);

        return $items;
    }
}