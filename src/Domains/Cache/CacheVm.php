<?php

namespace kosuha606\VirtualAdmin\Domains\Cache;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $entity_id
 * @property $entity_class
 * @property $data
 *
 * @method static normalizeTableName($name)
 * @method static buildColumnsByData($data)
 * @method static createTable($tableName, $fieldsConfig)
 * @method static dropTable($tableName)
 * @method static isTableExists($tableName)
 * @method static getData($tableName, $whereConfig)
 * @method static insertData($tableName, $whereConfig)
 * @method static deleteData($tableName, $whereConfig)
 *
 */
class CacheVm extends VirtualModelEntity
{
    const KEY = 'cache';

    public static function providerType()
    {
        return self::KEY;
    }

    public function attributes(): array
    {
        return [
            'id',
        ];
    }
}