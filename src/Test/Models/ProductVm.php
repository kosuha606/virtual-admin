<?php

namespace kosuha606\VirtualAdmin\Test\Models;

use kosuha606\VirtualModel\VirtualModel;

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
class ProductVm extends VirtualModel
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