<?php

namespace kosuha606\VirtualAdmin\Domains\User;

use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualAdmin\Domains\User\UserVm;

class UserService
{
    /** @var UserVm */
    private $user;

    /**
     * @param $userId
     * @throws \Exception
     */
    public function login($userId)
    {
        $user = VirtualModelManager::getEntity(UserVm::class)::one([
            'where' => [
                ['=', 'id', $userId]
            ]
        ]);
        $this->user = $user;
    }

    public function current()
    {
        $this->user->getCookieKey();
        return $this->user;
    }

    public function setUser(UserVm $user)
    {
        $this->user = $user;
    }
}