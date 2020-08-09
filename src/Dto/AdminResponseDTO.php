<?php

namespace kosuha606\VirtualAdmin\Dto;

/**
 * @package kosuha606\VirtualAdmin\Dto
 */
class AdminResponseDTO
{
    public $html = '';

    public $json = [
        'result' => true,
    ];

    public $jsVars = [];

    public function __construct($html, $jsVars)
    {
        $this->html = $html;
        $this->jsVars = $jsVars;
        $this->json = array_merge($this->json, $jsVars);
    }
}