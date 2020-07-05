<?php

namespace kosuha606\VirtualAdmin\Test\Models;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * Продукт
 * @property $rests
 *
 * @property $id
 * @property $name
 * @property $price
 * @property $slug
 * @property $price2B
 * @property $actions
 * @property $photo
 * @property $category_id
 *
 */
class ProductVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'price',
            'slug',
            'price2B',
            'actions',
            'rests',
            'photo',
            'category_id',
        ];
    }
}