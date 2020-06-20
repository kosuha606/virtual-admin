<?php

namespace kosuha606\VirtualAdmin\Domains\Version;

use kosuha606\VirtualModel\VirtualModel;

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
        $version = VersionVm::one(['where' => [
            ['=', 'id', $versionId]
        ]]);

        if (!$version->id) {
            return;
        }

        $entityClass = $version->entity_class;
        $entityId = $version->entity_id;
        /** @var VirtualModel $entity */
        $entity = $entityClass::one(['where' => [
            ['=', 'id', $entityId]
        ]]);
        $attributesData = $version->attributesData();
        $attributesData['version_restored'] = 1;
        $entity->setAttributes($attributesData);
        $entity->save();
    }
}