<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Request;
use kosuha606\VirtualModel\VirtualModelManager;

class RequestService
{
    /** @var Request */
    public static $request;

    /**
     * @return void
     */
    public function clearRequest()
    {
        self::$request = null;
    }

    /**
     * @return Request
     * @throws \Exception
     */
    public function request(): Request
    {
        if (!self::$request) {
            self::$request = VirtualModelManager::getEntity(Request::class)::one(['where' => [['all']]]);
        }

        return self::$request;
    }
}
