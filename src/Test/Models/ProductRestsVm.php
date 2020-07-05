<?php

namespace kosuha606\VirtualAdmin\Test\Models;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * Остаток по продукту
 * @package kosuha606\Model\iteration2\model
 * Остаток по продукту
 * @property $qty
 */
class ProductRestsVm extends VirtualModelEntity
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