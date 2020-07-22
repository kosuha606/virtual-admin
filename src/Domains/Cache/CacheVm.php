<?php

namespace kosuha606\VirtualAdmin\Domains\Cache;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use kosuha606\VirtualAdmin\Domains\Multilang\LangVm;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ServiceManager;

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
 * @method static updateData($tableName, $whereConfig)
 * @method static deleteData($tableName, $whereConfig)
 *
 */
class CacheVm extends VirtualModelEntity
{
    const KEY = 'cache';

    /** @var LanguageService */
    private static $langService;

    public function langAttribute($name)
    {
        if (!self::$langService) {
            self::$langService = ServiceManager::getInstance()->get(LanguageService::class);
        }

        $lang = self::$langService->getLang();
        $attrName  = $name.'_'.$lang->code;

        return $this->attributes[$attrName] ?? null;
    }

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