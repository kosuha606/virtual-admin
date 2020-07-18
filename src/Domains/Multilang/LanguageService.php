<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualAdmin\Model\Session;
use kosuha606\VirtualAdmin\Services\SessionService;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Multilang
 */
class LanguageService
{
    const SESSION_KEY = 'language';

    /**
     * @var SessionService
     */
    private $sessionService;

    private static $langs;

    private static $currentLang;

    /**
     * LanguageService constructor.
     * @param SessionService $sessionService
     * @throws \Exception
     */
    public function __construct(
        SessionService $sessionService
    ) {
        $this->sessionService = $sessionService;
        self::$langs = VirtualModelManager::getEntity(LangVm::class)::many(['where' => [['all']]], 'code');
    }

    /**
     * @return LangVm
     * @throws \Exception
     */
    public function getLang()
    {
        /** @var Session $lang */
        $lang = $this->sessionService->get(self::SESSION_KEY);

        if ($lang) {
            $lang = $lang->value;
        }

        if (!$lang) {
            $lang = 'ru';
        }

        if (!self::$currentLang) {
            self::$currentLang = LangVm::one(['where' => [
                ['=', 'code', $lang]
            ]]);
        }

        return self::$currentLang;
    }

    /**
     * @param $code
     * @throws \Exception
     */
    public function setLang($code)
    {
        $this->sessionService->save(self::SESSION_KEY, $code);
    }

    /**
     * @return LangVm[]
     */
    public function getLanguages()
    {
        return self::$langs;
    }
}