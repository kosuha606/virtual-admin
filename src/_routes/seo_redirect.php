<?php


use kosuha606\VirtualAdmin\Domains\Seo\SeoRedirectVm;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Structures\ListComponents;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'seo_redirect';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = SeoRedirectVm::class;
$listTitle = 'SEO редиректы';
$detailTitle = 'SEO редиректы';

return [
    'routes' => [
        $baseEntity => [
            'list' => [
                'menu' => [
                    'name' => $baseEntity.'_list',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/list',
                    'parent' => 'seo',
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
                            'field' => 'from_url',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Из',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'to_url',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'В',
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
                        return [
                            [
                                'field' => 'from_url',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Из',
                                'value' => $model->from_url,
                            ],
                            [
                                'field' => 'to_url',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'В',
                                'value' => $model->to_url,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];