<?php

namespace kosuha606\VirtualAdmin\Services;

use kosuha606\VirtualAdmin\Model\Request;

/**
 * @package kosuha606\VirtualAdmin\Services
 */
class RequestService
{
    /** @var Request */
    public static $request;

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
            self::$request = Request::one(['where' => [['all']]]);
        }

        return self::$request;
    }
}