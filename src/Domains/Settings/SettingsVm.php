<?php

namespace kosuha606\VirtualAdmin\Domains\Settings;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @package kosuha606\VirtualAdmin\Domains\Settings
 */
class SettingsVm extends VirtualModel
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