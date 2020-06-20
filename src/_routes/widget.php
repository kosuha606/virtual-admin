<?php


use kosuha606\VirtualAdmin\Domains\Design\WidgetVm;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Structures\ListComponents;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'widget';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = WidgetVm::class;
$listTitle = 'Виджет';
$detailTitle = 'Виджет';

return [
    'routes' => [
        $baseEntity => [
            'list' => [
                'menu' => [
                    'name' => $baseEntity.'_list',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/list',
                    'parent' => 'system',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $listTitle,
                    'entity' => $baseEntity,
                    'component' => 'list',
                    'ad_url' => '/admin/'.$baseEntity.'/detail',
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionList',
                        'orderBy' => [
                            'field' => 'id',
                            'direction' => 'desc',
                        ],
                    ],
                    'filter_config' => [
                        [
                            'field' => 'id',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'ID',
                        ],
                    ],
                    'list_config' => [
                        [
                            'field' => 'id',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'ID'
                        ],
                        [
                            'field' => 'name',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Название',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                    ]
                ]
            ],
            'detail' => [
                'menu' => [
                    'name' => 'ad_category_detail',
                    'label' => 'Категория',
                    'url' => '/admin/ad_category/detail',
                    'visible' => false,
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $detailTitle,
                    'entity' => $baseEntity,
                    'component' => 'detail',
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionView',
                    ],
                    'config' => function ($model) {
                        $stringService = ServiceManager::getInstance()->get(StringService::class);

                        return [
                            [
                                'field' => 'name',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Название',
                                'value' => $model->name,
                            ],
                            [
                                'field' => 'widget_class',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Класс',
                                'value' => $model->widget_class,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];