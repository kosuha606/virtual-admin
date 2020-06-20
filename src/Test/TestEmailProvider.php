<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Domains\Email\Email;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestEmailProvider extends MemoryModelProvider
{
    public function type()
    {
        return Email::KEY;
    }

    public function send($ids)
    {
        // send ids
    }
}