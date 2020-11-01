<?php

namespace kosuha606\VirtualAdmin\Interfaces;

interface AdminRoutesLoaderInterface
{
    /**
     * @return array
     */
    public function routesData(): array;
}