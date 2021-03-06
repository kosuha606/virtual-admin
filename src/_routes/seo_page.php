<?php


use kosuha606\VirtualAdmin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Structures\ListComponents;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'seo_page';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = SeoPageVm::class;
$listTitle = 'SEO страницы';
$detailTitle = 'SEO страницы';

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
                    'filter' => [
                        ['=', 'entity_id', null]
                    ],
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
                            'field' => 'title',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Заголовок',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'entity_class',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Класс',
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
                    'h1' => function($model) use($detailTitle) {
                        return ($detailTitle.' '.$model->title ?: $detailTitle );
                    },
                    'entity' => $baseEntity,
                    'component' => 'detail',
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionView',
                    ],
                    'config' => function ($model) {
                        return [
                            [
                                'field' => 'entity_id',
                                'component' => DetailComponents::HIDDEN_FIELD,
                                'label' => '',
                                'value' => $model->entity_id,
                            ],
                            [
                                'field' => 'entity_class',
                                'component' => DetailComponents::HIDDEN_FIELD,
                                'label' => '',
                                'value' => $model->entity_class,
                            ],
                            [
                                'field' => 'url',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Url',
                                'value' => $model->url,
                            ],
                            [
                                'field' => 'title',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Заголовок',
                                'value' => $model->title,
                            ],
                            [
                                'field' => 'meta_keywords',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Ключевые слова',
                                'value' => $model->meta_keywords,
                            ],
                            [
                                'field' => 'mata_description',
                                'component' => DetailComponents::TEXTAREA_FIELD,
                                'label' => 'Мета описания',
                                'value' => $model->mata_description,
                            ],
                            [
                                'field' => 'og_title',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'OG title',
                                'value' => $model->og_title,
                            ],
                            [
                                'field' => 'og_description',
                                'label' => 'OG описание',
                                'component' => DetailComponents::TEXTAREA_FIELD,
                                'value' => $model->og_description,
                            ],
                            [
                                'field' => 'og_url',
                                'label' => 'OG адресс',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->og_url,
                            ],
                            [
                                'field' => 'og_image',
                                'label' => 'OG изображение',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->og_image,
                            ],
                            [
                                'field' => 'og_type',
                                'label' => 'OG тип',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->og_type,
                            ],
                            [
                                'field' => 'canonical',
                                'label' => 'Canonical',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->canonical,
                            ],
                            [
                                'field' => 'noindex',
                                'label' => 'Noindex',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->noindex,
                            ],
                            [
                                'field' => 'sitemap_importance',
                                'label' => 'Sitemap приоритет',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->sitemap_importance,
                            ],
                            [
                                'field' => 'sitemap_freq',
                                'label' => 'Sitemap частота обновления',
                                'component' => DetailComponents::INPUT_FIELD,
                                'value' => $model->sitemap_freq,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];