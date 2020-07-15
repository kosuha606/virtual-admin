<?php

namespace kosuha606\VirtualAdmin\Domains\User;

use kosuha606\VirtualAdmin\Domains\Cookie\CookieVm;
use kosuha606\VirtualAdmin\Services\PermissionService;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * Пользователь
 * @package kosuha606\Model\iteration2\model
 * @property $id
 */
class UserVm extends VirtualModelEntity
{
    const UNIQ_COOKIE_KEY = 'user_token';

    private static $cookieWasSet = false;

    public function attributes(): array
    {
        return [
            'id',
            'name',
            'email',
            'role',
            'personalDiscount',
            'password',
        ];
    }

    public function __construct($environment = 'db')
    {
        parent::__construct($environment);
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function isAdmin()
    {
        try {
            ServiceManager::getInstance()->get(PermissionService::class)->ensureActionAvailable('admin.access', $this);
            return true;
        } catch (\Throwable $exception) {
            return false;
        }

        return false;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $attributes['personalDiscount'] = 0;
        return parent::setAttributes($attributes);
    }

    public function isB2C()
    {
        return $this->role === 'b2c';
    }

    public function isB2B()
    {
        return $this->role === 'b2b';
    }

    public function isGuest()
    {
        return empty($this->attributes['id']);
    }

    /**
     * Уникальный cookie ключ пользователя
     */
    public function getCookieKey()
    {
        if (!CookieVm::get(self::UNIQ_COOKIE_KEY) && !static::$cookieWasSet) {
            CookieVm::set(self::UNIQ_COOKIE_KEY, md5(time()), time()+3600*24*30);
            static::$cookieWasSet = true;
        }

        return CookieVm::get(self::UNIQ_COOKIE_KEY);
    }
}