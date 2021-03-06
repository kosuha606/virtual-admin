<?php

namespace kosuha606\VirtualAdmin\Domains\Cache;

use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

class CacheService
{
    /**
     * @param $entityClass
     * @param $whereConfig
     * @return CacheVm|null
     * @throws \Exception
     */
    public function one($entityClass, $whereConfig = [])
    {
        $tableName = VirtualModelManager::getEntity(CacheVm::class)::normalizeTableName($entityClass);
        $data = VirtualModelManager::getEntity(CacheVm::class)::getData($tableName, $whereConfig);

        if (!isset($data[0])) {
            return null;
        }

        return VirtualModelManager::getEntity(CacheVm::class)::create($data[0]);
    }

    /**
     * @param $entityClass
     * @return CacheVm[]
     * @throws \Exception
     */
    public function many($entityClass, $whereConfig = [])
    {
        $tableName = VirtualModelManager::getEntity(CacheVm::class)::normalizeTableName($entityClass);
        $data = VirtualModelManager::getEntity(CacheVm::class)::getData($tableName, $whereConfig);

        $result = [];
        foreach ($data as $datum) {
            $result[] = VirtualModelManager::getEntity(CacheVm::class)::create($datum);
        }

        return $result;
    }

    public function count($entityClass, $whereConfig = [])
    {
        $tableName = VirtualModelManager::getEntity(CacheVm::class)::normalizeTableName($entityClass);

        return VirtualModelManager::getEntity(CacheVm::class)::count($tableName, $whereConfig);
    }

    /**
     * Пересохраняет все модели, которые генерируют кэш
     * @throws \Exception
     */
    public function rebuildCache()
    {
        $storageProvider = VirtualModelManager::getInstance()->getProvider('storage');
        $storageClasses = $storageProvider->getAvailableModelClasses();

        $errors = [];

        foreach ($storageClasses as $storageClass) {
            if (class_implements($storageClass, CacheAimInterface::class)) {
                $models = $storageClass::many(['where' => [['all']]]);

                /** @var VirtualModelEntity $model */
                foreach ($models as $model) {
                    try {
                        $model->save();
                    } catch (\Exception $exception) {
                        $modelClass = get_class($model);
                        $errors[] = "{$modelClass} #{$model->id} {$exception->getMessage()}";
                    }
                }
            }
        }

        return $errors;
    }
}