<?php

use kosuha606\VirtualAdmin\Domains\Design\DesignVm;
use kosuha606\VirtualAdmin\Domains\Design\DesignWidgetVm;
use kosuha606\VirtualAdmin\Domains\Design\WidgetVm;
use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Structures\ListComponents;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ServiceManager;

$stringService = ServiceManager::getInstance()->get(StringService::class);

$baseEntity = 'design';
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = DesignVm::class;
$listTitle = 'Дизайн';
$detailTitle = 'Дизайн';

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
                    'additional_config' => function($model) {
                        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

                        $config = $secondaryService->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelField('design_id')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_MANY)
                            ->setRelationClass(DesignWidgetVm::class)
                            ->setTabName('Виджеты')
                            ->setRelationEntities(DesignWidgetVm::many(['where' => [['=', 'design_id', $model->id]]]))
                            ->setConfig(function ($inModel) use ($model) {
                                $stringService = ServiceManager::getInstance()->get(StringService::class);

                                return [
                                    [
                                        'field' => 'design_id',
                                        'label' => '',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => $model->id,
                                    ],
                                    [
                                        'field' => 'widget_id',
                                        'label' => 'Виджет',
                                        'component' => DetailComponents::SELECT_FIELD,
                                        'value' => $inModel->widget_id,
                                        'props' => [
                                            'items' => $stringService->map(VirtualModel::allToArray(WidgetVm::many(['where' => [['all']]])), 'id', 'name')
                                        ]
                                    ],
                                    [
                                        'field' => 'position',
                                        'label' => 'Позиция',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->position,
                                    ],
                                    [
                                        'field' => 'config',
                                        'label' => 'Конфигурация',
                                        'component' => DetailComponents::CONFIG_BUILDER_FIELD,
                                        'value' => $inModel->config,
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
                                'field' => 'route',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Роут',
                                'value' => $model->route,
                            ],
                            [
                                'field' => 'priority',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Приоритет',
                                'value' => $model->priority,
                            ],
                            [
                                'field' => 'template',
                                'component' => DetailComponents::HTML_FIELD,
                                'label' => 'Шаблон',
                                'value' => $model->template,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];