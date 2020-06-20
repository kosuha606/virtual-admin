<?php

namespace kosuha606\VirtualAdmin\Domains\User;

use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\UserVm;

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
        $user = VirtualModelManager::getInstance()->getProvider()->one(UserVm::class, [
            'where' => [
                ['=', 'id', $userId]
            ]
        ]);
        $this->user = $user;
    }

    public function current()
    {
        return $this->user;
    }

    public function setUser(UserVm $user)
    {
        $this->user = $user;
    }
}