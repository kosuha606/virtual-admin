<?php

namespace kosuha606\VirtualAdmin\Model;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @property $get
 * @property $post
 * @property $isAjax
 * @property $isPost
 * @property $pathInfo
 */
class Request extends VirtualModelEntity
{
    const TYPE = 'request';

    public static function providerType()
    {
        return self::TYPE;
    }

    public function attributes(): array
    {
        return [
            'pathInfo',
            'get',
            'post',
            'isAjax',
            'isPost',
        ];
    }
}