<?php

namespace kosuha606\VirtualAdmin\Domains\Cache;

class CacheAimObserver
{
    const CACHE_BUILD_DATE = 'cache_built_date';

    private function processAimAction(CacheAimInterface $aim, $action)
    {
        /** @var CacheEntityDto $cacheEntityDto */
        foreach ($aim->cacheItems() as $cacheEntityDto) {
            $tableName = CacheVm::normalizeTableName($cacheEntityDto->getCacheClass());

            if (
                !CacheVm::isTableExists($tableName)
                && $cacheEntityDto->getCacheAction() === 'insert'
            ) {
                $this->createCacheTable($tableName, $cacheEntityDto->getCacheData());
            }

            $cacheHandler = $cacheEntityDto->getHandler();

            if (is_callable($cacheHandler)) {
                $cacheHandler($action);
            }

            $this->saveOneEntity($tableName, $cacheEntityDto);
        }
    }

    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    public function afterSave(CacheAimInterface $aim)
    {
        $this->processAimAction($aim, 'afterSave');
    }

    public function afterDelete(CacheAimInterface $aim)
    {
        $this->processAimAction($aim, 'afterDelete');
    }

    public function afterDeleteByCondition($aim)
    {
        $k = 1;
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
        if ($cacheEntityDto->getCacheAction() === 'insert') {
            // Очищаем стырй кэш
            CacheVm::deleteData($tableName, ['=', $cacheEntityDto->getCacheIdField(), $cacheEntityDto->getCacheId()]);

            // Создаем новый кэш
            $normalizedCacheData = $this->normalizeEntityData($cacheEntityDto->getCacheData());
            $normalizedCacheData[static::CACHE_BUILD_DATE] = date('Y-m-d H:i:s');
            CacheVm::insertData($tableName, $normalizedCacheData);
        }

        if ($cacheEntityDto->getCacheAction() === 'update') {
            $normalizedCacheData = $this->normalizeEntityData($cacheEntityDto->getCacheData());
            $normalizedCacheData[static::CACHE_BUILD_DATE] = date('Y-m-d H:i:s');
            CacheVm::updateData($tableName, [
                'data' => $normalizedCacheData,
                'where' => ['=', $cacheEntityDto->getCacheIdField(), $cacheEntityDto->getCacheId()]
            ]);
        }
    }
}