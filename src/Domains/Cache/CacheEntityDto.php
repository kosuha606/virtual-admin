<?php

namespace kosuha606\VirtualAdmin\Domains\Cache;

class CacheEntityDto
{
    private $cacheId;

    private $cacheClass;

    private $cacheData;

    private $cacheIdField;

    private $cacheAction;

    private $handler;

    public function __construct(
        $cacheId,
        $cacheIdField,
        $cacheClass,
        $cacheData,
        $cacheAction = 'insert',
        $handler = null
    ) {
        $this->cacheId = $cacheId;
        $this->cacheClass = $cacheClass;
        $this->cacheData = $cacheData;
        $this->cacheIdField = $cacheIdField;
        $this->cacheAction = $cacheAction;
        $this->handler = $handler;
    }

    /**
     * @return mixed
     */
    public function getCacheId()
    {
        return $this->cacheId;
    }

    /**
     * @param mixed $cacheId
     */
    public function setCacheId($cacheId)
    {
        $this->cacheId = $cacheId;
    }

    /**
     * @return mixed
     */
    public function getCacheClass()
    {
        return $this->cacheClass;
    }

    /**
     * @param mixed $cacheClass
     */
    public function setCacheClass($cacheClass)
    {
        $this->cacheClass = $cacheClass;
    }

    /**
     * @return mixed
     */
    public function getCacheData()
    {
        return $this->cacheData;
    }

    /**
     * @param mixed $cacheData
     */
    public function setCacheData($cacheData)
    {
        $this->cacheData = $cacheData;
    }

    /**
     * @return mixed
     */
    public function getCacheIdField()
    {
        return $this->cacheIdField;
    }

    /**
     * @param mixed $cacheIdField
     */
    public function setCacheIdField($cacheIdField)
    {
        $this->cacheIdField = $cacheIdField;
    }

    /**
     * @return mixed
     */
    public function getCacheAction()
    {
        return $this->cacheAction;
    }

    /**
     * @param mixed $cacheIdField
     */
    public function setCacheAction($cacheIdField)
    {
        $this->cacheAction = $cacheIdField;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param mixed $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }
}