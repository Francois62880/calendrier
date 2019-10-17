<?php

namespace App\Date;

class Month {

    /**
     * Month contructor
     * @param int $month le mois compris entre 1 et 12
     * @param int $year l'année
     * @throws \Exception
     */

    public function __construct(int $month, int $year)
    {
        if ($month < 1 || $month > 12)
        {
            throw new \Exception("le mois $month n'est pas valide");
        }
        if ($year < 1970)
        {
            throw new \Exception("l'année est inférieur à 1970");
        }
    }
}