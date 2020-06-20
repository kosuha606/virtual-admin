<?php

namespace kosuha606\VirtualAdmin\Classes;

use kosuha606\VirtualAdmin\Interfaces\AdminRoutesLoaderInterface;
use kosuha606\VirtualAdmin\Services\AdminConfigService;
use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * Роуты по умолчанию для панели администратора
 *
 * @package kosuha606\VirtualAdmin\Classes
 */
class AdminDefaultRoutesLoader implements AdminRoutesLoaderInterface
{
    public function routesData(): array
    {
        $adminConfigService = ServiceManager::getInstance()->get(AdminConfigService::class);

        return $adminConfigService->loadConfigs(__DIR__.'/../_routes/');
    }
}