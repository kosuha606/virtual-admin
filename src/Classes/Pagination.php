<?php

namespace kosuha606\VirtualAdmin\Classes;

class Pagination
{
    /** @var int  */
    public $itemPerPage = 10;

    /** @var int  */
    public $defaultItemPerPage = 10;

    /** @var int  */
    public $page = 1;

    /** @var int  */
    public $totals = 0;

    /**
     * @param $page
     * @param $itemPerPage
     */
    public function __construct($page, $itemPerPage)
    {
        $this->page = $page;
        $this->itemPerPage = $itemPerPage;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->itemPerPage;
    }

    /**
     * @return float|int
     */
    public function getOffset()
    {
        return ($this->page-1)*$this->itemPerPage;
    }

    /**
     * @return float
     */
    public function getPages()
    {
        $pages = ceil($this->totals/$this->itemPerPage);

        return $pages;
    }
}
