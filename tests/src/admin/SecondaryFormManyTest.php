<?php

use kosuha606\VirtualAdmin\Domains\Comment\CommentVm;
use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Model\Request;
use kosuha606\VirtualAdmin\Model\Session;
use kosuha606\VirtualAdmin\Services\RequestService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Test\Models\ProductVm;
use kosuha606\VirtualAdmin\Test\TestRequestProvider;
use kosuha606\VirtualAdmin\Test\TestSessionProvider;
use kosuha606\VirtualModel\Example\Shop\Model\Product;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualModelHelppack\Test\VirtualTestCase;
use PHPUnit\Framework\TestCase;

class SecondaryFormManyTest extends VirtualTestCase
{
    /** @var TestSessionProvider */
    public $sessionProvider;

    /** @var TestRequestProvider */
    public $requestProvider;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->provider->memoryStorage = [
            CommentVm::class => [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'model_id' => 1,
                    'model_class' => ProductVm::class,
                    'content' => 'Hello',
                ],
                [
                    'id' => 2,
                    'user_id' => 2,
                    'model_id' => 1,
                    'model_class' => ProductVm::class,
                    'content' => 'World',
                ],
            ],
            ProductVm::class => [
                [
                    'id' => 1,
                    'name' => 'Первый',
                    'price' => 100,
                    'price2B' => 200,
                ],
                [
                    'id' => 2,
                    'name' => 'Второй',
                    'price' => 200,
                    'price2B' => 300,
                ],
            ]
        ];

        $this->sessionProvider = new TestSessionProvider();
        $this->requestProvider = new TestRequestProvider();

        VirtualModelManager::getInstance()->setProvider($this->sessionProvider);
        VirtualModelManager::getInstance()->setProvider($this->requestProvider);
    }

    public function tearDown()
    {
        RequestService::$request = null;
        unset($this->sessionProvider);
        unset($this->requestProvider);
        parent::tearDown();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    public function testMultiProcess()
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $product = ProductVm::one(['where' => [['=', 'id', 1]]]);
        $secondaryService->processRememberedForm($product);

        // Устанавливаем состояние сессии
        $this->sessionProvider->memoryStorage = [
            Session::class => [
                [
                    'id' => 0,
                    'key' => $secondaryService->getRealSessionKey(),
                    'value' => [
                        CommentVm::class => [
                            'masterModelId' => '1,'.ProductVm::class,
                            'masterModelField' => 'model_id,model_class',
                            'masterModelClass' => ProductVm::class,
                            'relationType' => SecondaryFormBuilder::ONE_TO_MANY
                        ]
                    ]
                ]
            ]
        ];

        $this->requestProvider->memoryStorage = [
            Request::class => [
                [
                    'get' => [],
                    'post' => [
                        'secondary_form' => [
                            CommentVm::class => [
                                [
                                    'user_id' => 1,
                                    'model_id' => 1,
                                    'model_class' => ProductVm::class,
                                    'content' => 'Hello',
                                ],
                                [
                                    'user_id' => 2,
                                    'model_id' => 1,
                                    'model_class' => ProductVm::class,
                                    'content' => 'World',
                                ],
                            ]
                        ]
                    ],
                    'isAjax' => false,
                    'isPost' => true,
                ]
            ]
        ];

        $this->assertEquals(2, count($this->provider->memoryStorage[CommentVm::class]));
    }

}