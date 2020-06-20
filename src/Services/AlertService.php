<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Alert;

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
        return Alert::many(['where' => [['all']]]);
    }

    /**
     * @param $message
     * @throws \Exception
     */
    public function success($message)
    {
        Alert::create([
            'type' => 'success',
            'message' => $message
        ])->save();
    }

    public function error($message)
    {
        Alert::create([
            'type' => 'error',
            'message' => $message
        ])->save();
    }
}