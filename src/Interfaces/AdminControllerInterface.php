<?php

namespace kosuha606\VirtualAdmin\Interfaces;

interface AdminControllerInterface
{
    /**
     * @param $view
     * @param $args
     * @return mixed
     */
    public function renderView($view, $args);
}