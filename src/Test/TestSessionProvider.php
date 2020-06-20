<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Model\Session;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSessionProvider extends MemoryModelProvider
{
    public function type()
    {
        return Session::TYPE;
    }
}