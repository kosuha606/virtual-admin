<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Permission;
use kosuha606\VirtualAdmin\Domains\User\UserVm;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

class PermissionService
{
    /**
     * @param $action
     * @param $user
     * @return void
     * @throws \Exception
     */
    public function ensureActionAvailable($action, UserVm $user)
    {
        /** @var Permission $permission */
        $permission = VirtualModelManager::getEntity(Permission::class)::one(['where' => [
            ['=', 'action', $action],
            ['=', 'user_id', $user->id]
        ]]);

        if ($permission->action !== $action) {
            Permission::throw403();
        }
    }

    /**
     * @param $entity
     * @param $user
     * @return void
     * @throws \Exception
     */
    public function ensureEntityTypeAvailable($entityType, UserVm $user)
    {
        /** @var Permission $permission */
        $permission = VirtualModelManager::getEntity(Permission::class)::one(['where' => [
            ['=', 'entity', $entityType],
            ['=', 'user_id', $user->id]
        ]]);

        if ($permission->entity !== $entityType) {
            Permission::throw403();
        }
    }

    /**
     * @param $entity
     * @param $user
     * @return void
     * @throws \Exception
     */
    public function ensureEntityAvailable(VirtualModelEntity $entity, UserVm $user)
    {
        /** @var Permission $permission */
        $permission = VirtualModelManager::getEntity(Permission::class)::one(['where' => [
            ['=', 'entity', get_class($entity)],
            ['=', 'entity_id', $entity->id],
            ['=', 'user_id', $user->id]
        ]]);

        if ($permission->entity !== get_class($entity)) {
            Permission::throw403();
        }
    }
}
