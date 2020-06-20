<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Session;

/**
 * @package kosuha606\VirtualAdmin\Services
 */
class SessionService
{
    /**
     * @param $key
     * @return Session
     * @throws \Exception
     */
    public function get($key): Session
    {
        return Session::one(['where' => [['=', 'key', $key]]]);
    }

    /**
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public function save($key, $value)
    {
        $session = Session::one(['where' => [['=', 'key', $key]]]);
        if ($session->value) {
            $this->remove($key);
        }

        Session::create([
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
        $session = Session::one(['where' => [['=', 'key', $key]]]);
        if ($session->value) {
            $session->delete();
        }
    }
}