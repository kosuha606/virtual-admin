<?php

namespace kosuha606\VirtualAdmin\Dto;

class AdminResponseDTO
{
    /** @var string  */
    public $html = '';

    /** @var array  */
    public $json = [
        'result' => true,
    ];

    /** @var array  */
    public $jsVars = [];

    /**
     * @param $html
     * @param $jsVars
     */
    public function __construct($html, $jsVars)
    {
        $this->html = $html;
        $this->jsVars = $jsVars;
        $this->json = array_merge($this->json, $jsVars);
    }
}
