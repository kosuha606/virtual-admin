<?php

namespace kosuha606\VirtualAdmin\Domains\Version;

use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Version
 */
class VersionService
{
    /**
     * @param $versionId
     * @throws \Exception
     */
    public function restoreById($versionId)
    {
        $version = VirtualModelManager::getEntity(VersionVm::class)::one(['where' => [
            ['=', 'id', $versionId]
        ]]);

        if (!$version->id) {
            return;
        }

        $entityClass = $version->entity_class;
        $entityId = $version->entity_id;
        /** @var VirtualModelEntity $entity */
        $entity = VirtualModelManager::getEntity($entityClass)::one(['where' => [
            ['=', 'id', $entityId]
        ]]);
        $attributesData = $version->attributesData();
        $attributesData['version_restored'] = 1;
        $entity->setAttributes($attributesData);
        $entity->save();
    }
}