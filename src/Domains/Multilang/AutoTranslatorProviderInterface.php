<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

interface AutoTranslatorProviderInterface
{
    public function autoTranslate($fromLang, $toLang, $string);
}