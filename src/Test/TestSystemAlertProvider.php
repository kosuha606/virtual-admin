<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSystemAlertProvider extends MemoryModelProvider
{
    public function type()
    {
        return 'system_alert';
    }
}