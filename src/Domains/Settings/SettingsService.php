<?php

namespace kosuha606\VirtualAdmin\Domains\Settings;

use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Settings
 */
class SettingsService
{
    /** @var SettingsProviderInterface */
    private $provider;

    private $defaultSettings = [];

    private $settings = [];

    private $settingsHash = [];

    /**
     * SettingsService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->provider = VirtualModelManager::getInstance()->getProvider(SettingsVm::KEY);

        if (!$this->provider instanceof SettingsProviderInterface) {
            throw new \Exception('settings provider must implement SettingProviderInterface');
        }

        $this->defaultSettings = $this->provider->getDefaultSettings();
        $this->settings = $this->provider->getSettings();
        $resultSettings = $this->defaultSettings;

        if ($this->settings) {
            foreach ($this->settings as $tab => $setList) {
                foreach ($setList as $setItem) {
                    if (!isset($resultSettings[$tab])) {
                        continue;
                    }

                    foreach ($resultSettings[$tab] as &$resultSettingItem) {
                        if ($resultSettingItem['field'] === $setItem['field']) {
                            $resultSettingItem['value'] = $setItem['value'];
                        }
                    }
                }
            }
        }

        $this->settings = $resultSettings;
        $this->buildSettingsHash();
    }

    private function buildSettingsHash()
    {
        foreach ($this->settings as $tab => $setItems) {
            foreach ($setItems as $setItem) {
                $this->settingsHash[$setItem['field']] = $setItem['value'];
            }
        }
    }

    /**
     * Получить все настройки
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @return array
     */
    public function getSettingsHash(): array
    {
        return $this->settingsHash;
    }

    /**
     * Сохранить настройки
     */
    public function saveSettings($settings)
    {
        $this->provider->saveSettings($settings);
    }

    /**
     * Получить одно значение
     * @param $category
     * @param $field
     * @return mixed
     * @throws \Exception
     */
    public function setting($field)
    {
        if (!isset($this->settingsHash[$field])) {
            throw new \Exception("No field $field in Settings, ensure you set it in default_settings");
        }

        return $this->settingsHash[$field];
    }
}