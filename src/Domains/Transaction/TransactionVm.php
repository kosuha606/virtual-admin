<?php

namespace kosuha606\VirtualAdmin\Domains\Transaction;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @method static begin($name)
 * @method static commit($name)
 * @method static rollback($name)
 */
class TransactionVm extends VirtualModelEntity
{
    const KEY = 'transation';

    public static function providerType()
    {
        return self::KEY;
    }

    public function attributes(): array
    {
        return [
            'is_started',
        ];
    }
}
