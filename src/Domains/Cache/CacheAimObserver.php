<?php

namespace kosuha606\VirtualAdmin\Domains\Cache;

class CacheAimObserver
{
    const CACHE_BUILD_DATE = 'cache_built_date';

    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    public function afterSave(CacheAimInterface $aim)
    {
        /** @var CacheEntityDto $cacheEntityDto */
        foreach ($aim->cacheItems() as $cacheEntityDto) {
            $tableName = CacheVm::normalizeTableName($cacheEntityDto->getCacheClass());

            if (!CacheVm::isTableExists($tableName)) {
                $this->createCacheTable($tableName, $cacheEntityDto->getCacheData());
            }

            $this->saveOneEntity($tableName, $cacheEntityDto);
        }
    }

    private function createCacheTable($tableName, $data)
    {
        $data[static::CACHE_BUILD_DATE] = date('Y-m-d H:i:s');
        $fieldsConfig = CacheVm::buildColumnsByData($data);

        CacheVm::createTable($tableName, $fieldsConfig);
    }

    private function normalizeEntityData($data)
    {
        foreach ($data as $key => &$datum) {
            if (is_array($datum)) {
                $datum = json_encode($datum, JSON_UNESCAPED_UNICODE);
            }
        }

        return $data;
    }

    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    private function saveOneEntity($tableName, CacheEntityDto $cacheEntityDto)
    {
        // Очищаем стырй кэш
        CacheVm::deleteData($tableName, ['=', $cacheEntityDto->getCacheIdField(), $cacheEntityDto->getCacheId()]);

        // Создаем новый кэш
        $normalizedCacheData = $this->normalizeEntityData($cacheEntityDto->getCacheData());
        $normalizedCacheData[static::CACHE_BUILD_DATE] = date('Y-m-d H:i:s');
        CacheVm::insertData($tableName, $normalizedCacheData);
    }
}