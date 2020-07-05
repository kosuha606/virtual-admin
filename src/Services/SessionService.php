<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Session;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Services
 */
class SessionService
{
    /**
     * @param $key
     * @return Session|mixed
     * @throws \Exception
     */
    public function get($key)
    {
        return VirtualModelManager::getEntity(Session::class)::one(['where' => [['=', 'key', $key]]]);
    }

    /**
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public function save($key, $value)
    {
        $session = VirtualModelManager::getEntity(Session::class)::one(['where' => [['=', 'key', $key]]]);
        if ($session->value) {
            $this->remove($key);
        }

        VirtualModelManager::getEntity(Session::class)::create([
            'key' => $key,
            'value' => $value
        ])->save();
    }

    /**
     * @param $key
     * @throws \Exception
     */
    public function remove($key)
    {
        $session = VirtualModelManager::getEntity(Session::class)::one(['where' => [['=', 'key', $key]]]);
        if ($session->value) {
            $session->delete();
        }
    }
}