<?php

namespace kosuha606\VirtualAdmin\Domains\Search;

interface SearchableInterface
{
    public function buildIndex(): SearchIndexDto;
}