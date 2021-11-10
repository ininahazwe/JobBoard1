<?php

namespace App\Data;

use App\Entity\Dictionnaire;

class SearchDataAnnonce
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
    public array $secteur = [];

    /**
     * @var Dictionnaire[]
     */
    public array $diplome = [];

    /**
     * @var Dictionnaire[]
     */
    public array $contrat = [];

    /**
     * @var Dictionnaire[]
     */
    public array $zone = [];

}