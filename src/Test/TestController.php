<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Interfaces\AdminControllerInterface;

class TestController implements AdminControllerInterface
{
    public function renderView($view, $args)
    {
        extract($args);
        ob_implicit_flush(true);
        ob_start();
        require __DIR__.'/views/'.$view.'.php';
        $content = ob_get_clean();

        return $content;
    }
}