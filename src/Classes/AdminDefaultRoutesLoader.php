<?php

namespace kosuha606\VirtualAdmin\Classes;

use kosuha606\VirtualAdmin\Interfaces\AdminRoutesLoaderInterface;
use kosuha606\VirtualAdmin\Services\AdminConfigService;
use kosuha606\VirtualModelHelppack\ServiceManager;

class AdminDefaultRoutesLoader implements AdminRoutesLoaderInterface
{
    /**
     * @return array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function routesData(): array
    {
        $adminConfigService = ServiceManager::getInstance()->get(AdminConfigService::class);

        return $adminConfigService->loadConfigs(__DIR__.'/../_routes/');
    }
}
