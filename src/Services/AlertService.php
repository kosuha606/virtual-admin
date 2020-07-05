<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Alert;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Services
 */
class AlertService
{
    /**
     * @return Alert[]
     * @throws \Exception
     */
    public function getAll()
    {
        return VirtualModelManager::getEntity(Alert::class)::many(['where' => [['all']]]);
    }

    /**
     * @param $message
     * @throws \Exception
     */
    public function success($message)
    {
        VirtualModelManager::getEntity(Alert::class)::create([
            'type' => 'success',
            'message' => $message
        ])->save();
    }

    /**
     * @param $message
     * @throws \Exception
     */
    public function error($message)
    {
        VirtualModelManager::getEntity(Alert::class)::create([
            'type' => 'error',
            'message' => $message
        ])->save();
    }
}