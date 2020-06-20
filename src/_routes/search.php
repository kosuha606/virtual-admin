<?php


use kosuha606\VirtualAdmin\Domains\Search\SearchService;
use kosuha606\VirtualAdmin\Domains\Search\SearchVm;
use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use kosuha606\VirtualAdmin\Services\AlertService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'search';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = SearchVm::class;
$listTitle = 'Поиск';
$detailTitle = 'Поиск';

return [
    'routes' => [
        $baseEntity => [
            'reindex' => [
                'handler' => function() {
                    $result = [];
                    ServiceManager::getInstance()->get(AlertService::class)->success('Поиск переиндексирован');
                    ServiceManager::getInstance()->get(SearchService::class)->reindexAll();

                    return new AdminResponseDTO('', $result);
                },
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'system',
                    'sort' => 99,
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
                        $infoDto = ServiceManager::getInstance()->get(SearchService::class)->indexInfo();
                        $k = 1;

                        return [
                            [
                                'field' => 'name',
                                'component' => 'SearchPage',
                                'label' => 'Название',
                                'props' => [
                                    'numDocs' => $infoDto->getNumbDocs()
                                ]
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];