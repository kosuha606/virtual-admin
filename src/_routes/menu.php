<?php


use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'menu';

$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);

$listTitle = 'Меню';
$detailTitle = 'Меню';

return [
    'menu' => [
        'seo' => [
            'name' => 'seo',
            'label' => 'SEO',
        ],
        'inter' => [
            'name' => 'inter',
            'label' => 'Интернационализация',
        ],
        'system' => [
            'name' => 'system',
            'label' => 'Система',
        ],
        'users' => [
            'name' => 'users',
            'label' => 'Пользователи',
        ],
    ]
];