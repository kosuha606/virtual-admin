<?php

namespace kosuha606\VirtualAdmin\Interfaces;

/**
 * @package kosuha606\VirtualAdmin\Interfaces
 */
interface AdminControllerInterface
{
    public function renderView($view, $args);
}