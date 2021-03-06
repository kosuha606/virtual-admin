<?php

namespace kosuha606\VirtualAdmin\Domains\Search;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $entity_id
 * @property $entity_class
 *
 *
 * @method static index($model)
 * @method static info()
 * @method static batchIndex($models)
 * @method static removeIndex($model)
 * @method static search($text)
 * @method static advancedSearch($config)
 */
class SearchVm extends VirtualModelEntity
{
    const KEY = 'search';

    public static function providerType()
    {
        return self::KEY;
    }

    public function attributes(): array
    {
        return [
            'id',
            'title',
            'description',
            'entity_id',
            'entity_class',
        ];
    }
}