<?php

namespace kosuha606\VirtualAdmin\Domains\Comment;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $user_id
 * @property $model_id
 * @property $model_class
 * @property $content
 * @property $created_at
 *
 */
class CommentVm extends VirtualModelEntity
{
    public function attributes(): array
    {
        return [
            'id',
            'user_id',
            'model_id',
            'model_class',
            'content',
            'created_at',
        ];
    }
}