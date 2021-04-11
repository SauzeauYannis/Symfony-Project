<?php

namespace App\Services;


class MyService
{
    /**
     * @param array $tab
     * @return int
     */
    public function tabSum(array $tab): int
    {
        $result = 0;

        foreach ($tab as $value)
            $result += $value;

        return $result;
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */