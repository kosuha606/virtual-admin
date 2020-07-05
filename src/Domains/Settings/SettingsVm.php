<?php

namespace kosuha606\VirtualAdmin\Domains\Settings;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @package kosuha606\VirtualAdmin\Domains\Settings
 */
class SettingsVm extends VirtualModelEntity
{
    const KEY = SettingsProviderInterface::class;

    public function attributes(): array
    {
        return [
            'id',
            'config'
        ];
    }
}