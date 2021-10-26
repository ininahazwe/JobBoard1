<?php

namespace App\Data;

use App\Entity\Dictionnaire;

class SearchDataProfile
{
    /**
     * @var int
     */
    public int $page = 1;

    /**
     * @var string
     */
    public string $q;

    /**
     * @var Dictionnaire[]
     */
    public array $typeDiplome = [];

    /**
     * @var Dictionnaire[]
     */
    public array $zonegeographique = [];

}