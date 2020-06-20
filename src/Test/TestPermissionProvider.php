<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Model\Permission;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestPermissionProvider extends MemoryModelProvider
{
    public function type()
    {
        return Permission::TYPE;
    }

    public function throw403()
    {
        throw new \Exception();
    }

    protected function findOne($modelClass, $config)
    {
        $data = [];

        foreach($config['where'] as $whereConfig) {
            $data[$whereConfig[1]] = $whereConfig[2];
        }

        return $data;
    }
}