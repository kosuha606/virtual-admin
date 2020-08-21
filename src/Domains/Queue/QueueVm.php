<?php

namespace kosuha606\VirtualAdmin\Domains\Queue;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $job_class
 * @property $job_id
 * @property $arguments
 * @property $created_at
 * @property $start_after
 *
 */
class QueueVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'job_class',
            'job_id',
            'arguments',
            'start_after',
            'created_at',
        ];
    }
}