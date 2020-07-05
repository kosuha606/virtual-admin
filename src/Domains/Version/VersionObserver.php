<?php

namespace kosuha606\VirtualAdmin\Domains\Version;

use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * Наблюдатель для сущностей VM для которых нужно следить за версиями данных
 * Максимум 10 последних версий
 */
class VersionObserver
{
    /**
     * @param VirtualModelEntity $model
     * @throws \Exception
     */
    private function deleteLastVersions(VirtualModelEntity $model)
    {
        $entityId = $model->id;
        $entityClass = get_class($model);

        /** @var VersionVm[] $versions */
        $versions = VirtualModelManager::getEntity(VersionVm::class)::many([
            'where' => [
                ['=', 'entity_id', $entityId],
                ['=', 'entity_class', $entityClass]
            ],
            'orderBy' => ['created_at' => SORT_ASC]
        ]);

        if (count($versions) >= 10) {
            $versions[0]->delete();
        }
    }

    /**
     * @param $model
     * @throws \Exception
     */
    public function beforeSave(VirtualModelEntity $model)
    {
        if (!$model->id) {
            return;
        }

        if ($model->hasAttribute('version_restored')) {
            return;
        }

        $this->deleteLastVersions($model);

        $entityId = $model->id;
        $entityClass = get_class($model);
        VirtualModelManager::getEntity(VersionVm::class)::create([
            'entity_id' => $entityId,
            'entity_class' => $entityClass,
            'attributes' => json_encode($model->getAttributes(), JSON_UNESCAPED_UNICODE),
            'created_at' => date('Y-m-d H:i:s'),
        ])->save();
    }
}