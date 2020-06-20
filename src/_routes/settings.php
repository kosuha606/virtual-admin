<?php


use kosuha606\VirtualAdmin\Domains\Settings\SettingsService;
use kosuha606\VirtualAdmin\Domains\Settings\SettingsVm;
use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use kosuha606\VirtualAdmin\Services\AlertService;
use kosuha606\VirtualAdmin\Services\RequestService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'settings';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = SettingsVm::class;
$listTitle = 'Настройки';
$detailTitle = 'Настройки';

return [
    'routes' => [
        $baseEntity => [
            'save' => [
                'handler' => function() {
                    $settingsService = ServiceManager::getInstance()->get(SettingsService::class);
                    $request = ServiceManager::getInstance()->get(RequestService::class)->request();
                    $data = $request->post['data'] ?? [];
                    $settingsService->saveSettings($data);
                    ServiceManager::getInstance()->get(AlertService::class)->success('Успешно сохранены настройки');

                    return new AdminResponseDTO('', [
                        'result' => true
                    ]);
                }
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'system',
                    'sort' => 100,
                ],
                'handler' => function() {
                    $settingsService = ServiceManager::getInstance()->get(SettingsService::class);
                    $settingsData = $settingsService->getSettings();

                    return new AdminResponseDTO('<settings-page :props="_admin.config"></settings-page>', [
                        'config' => [
                            'settingsData' => $settingsData
                        ],
                    ]);
                }
            ],
        ]
    ]
];
