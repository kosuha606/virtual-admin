<?php

namespace kosuha606\VirtualAdmin\Services;

class StringService
{
    public function map($data, $from, $to)
    {
        $result = [];

        foreach ($data as $datum) {
            $result[$datum[$from]] = $datum[$to];
        }

        return $result;
    }
}