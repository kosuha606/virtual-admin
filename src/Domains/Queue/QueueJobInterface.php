<?php

namespace kosuha606\VirtualAdmin\Domains\Queue;

interface QueueJobInterface
{
    public function run($arguments = []);
}