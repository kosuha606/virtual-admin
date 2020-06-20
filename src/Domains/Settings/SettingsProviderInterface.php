<?php

namespace kosuha606\VirtualAdmin\Domains\Settings;

/**
 * @package kosuha606\VirtualAdmin\Domains\Settings
 */
interface SettingsProviderInterface
{
    public function getDefaultSettings();

    public function getSettings();

    public function saveSettings($settings);
}