<?php


use kosuha606\VirtualAdmin\Domains\Menu\MenuItemVm;
use kosuha606\VirtualAdmin\Domains\Menu\MenuVm;
use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Structures\ListComponents;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'menu';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = MenuVm::class;
$listTitle = 'Меню';
$detailTitle = 'Меню';

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
                        [
                            'field' => 'code',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'Код',
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
                            'label' => 'Продукты',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'code',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Код'
                        ],
                        [
                            'field' => 'created_at',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Создан'
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
                    'additional_config' => function($model) {
                        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

                        $config = $secondaryService->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelField('menu_id')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_MANY)
                            ->setRelationClass(MenuItemVm::class)
                            ->setTabName('Пункты')
                            ->setRelationEntities(MenuItemVm::many([
                                'where' => [['=', 'menu_id', $model->id]],
                                'orderBy' => ['order' => SORT_ASC]
                            ]))
                            ->setConfig(function ($inModel) use ($model) {
                                return [
                                    [
                                        'field' => 'menu_id',
                                        'label' => '',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => $model->id,
                                    ],
                                    [
                                        'field' => 'id',
                                        'label' => '',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => $inModel->id,
                                    ],
                                    DetailComponents::MULTILANG_FIELD(
                                        DetailComponents::INPUT_FIELD,
                                        'label',
                                        'Заголовок',
                                        $inModel->label,
                                        $inModel
                                    ),
                                    [
                                        'field' => 'link',
                                        'label' => 'Ссылка',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->link,
                                    ],
                                    [
                                        'field' => 'order',
                                        'label' => 'Сортировка',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->order,
                                    ],
                                ];
                            })
                            ->getConfig()
                        ;

                        return [
                            $config,
                        ];
                    },
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
                                'field' => 'code',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Код',
                                'value' => $model->code,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];