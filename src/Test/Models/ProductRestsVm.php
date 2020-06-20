<?php

namespace kosuha606\VirtualAdmin\Test\Models;

use kosuha606\VirtualModel\VirtualModel;

/**
 * Остаток по продукту
 * @package kosuha606\Model\iteration2\model
 * Остаток по продукту
 * @property $qty
 */
class ProductRestsVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'productId',
            'qty',
            'userType',
        ];
    }
}