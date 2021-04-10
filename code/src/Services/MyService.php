<?php

namespace App\Services;


class MyService
{
    /**
     * @param array $argument
     * @return int
     */
    public function countTab($argument): int{
        $temp = 0;

        foreach ($argument as $digit){
            $temp += $digit;
        }
        return $temp;
    }
}