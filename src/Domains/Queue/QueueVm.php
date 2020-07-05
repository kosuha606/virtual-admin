<?php

namespace kosuha606\VirtualAdmin\Domains\Queue;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $job_class
 * @property $arguments
 * @property $created_at
 *
 */
class QueueVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'job_class',
            'arguments',
            'created_at',
        ];
    }
}