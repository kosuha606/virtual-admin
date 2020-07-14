<?php

use kosuha606\VirtualAdmin\Domains\User\UserVm;
use kosuha606\VirtualAdmin\Test\TestCookieProvider;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\Test\VirtualTestCase;

class UserTest extends VirtualTestCase
{
    /** @var TestCookieProvider */
    public $cookieProvider;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->cookieProvider = new TestCookieProvider();
        VirtualModelManager::getInstance()->setProvider($this->cookieProvider);
        $this->provider->memoryStorage = [
            UserVm::class => [
                [
                    'id' => 1,
                    'name' => 'user1',
                    'email' => 'user1@email.com',
                    'role' => 'customer',
                    'personalDiscount',
                    'password',
                ]
            ]
        ];
    }

    /**
     * @throws Exception
     */
    public function testCookie()
    {
        $user = UserVm::one(['where' => [
            ['=', 'id', 1]
        ]]);
        $cookie1 = $user->getCookieKey();

        $userSame = UserVm::one(['where' => [
            ['=', 'id', 1]
        ]]);
        $cookie2 = $userSame->getCookieKey();

        // Обе куки будут равны
        $this->assertEquals($cookie1, $cookie2);
        $this->assertEquals(1, count($this->cookieProvider->cookies));
    }
}