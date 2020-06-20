<?php


use kosuha606\VirtualAdmin\Domains\Seo\SeoUrlVm;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'seo_url';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = SeoUrlVm::class;
$listTitle = 'Генерировать url';
$detailTitle = 'Генерировать url';

return [
    'routes' => [
        $baseEntity => [
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'seo',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $detailTitle,
                    'entity' => $baseEntity,
                    'component' => 'detail',
                    'detail_config' => [
                        'noback' => true,
                        'notabs' => true,
                        'nobuttons' => true,
                    ],
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionView',
                    ],
                    'config' => function ($model) {
                        $seoUrlsCnt = SeoUrlVm::count(['where' => [['all']]]);

                        return [
                            [
                                'field' => 'name',
                                'component' => 'GenurlsPage',
                                'label' => 'Название',
                                'props' => [
                                    'urlsCnt' => $seoUrlsCnt,
                                ]
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];
