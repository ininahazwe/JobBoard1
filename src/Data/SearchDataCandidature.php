<?php

namespace App\Data;

use App\Entity\Annonce;
use App\Entity\Candidature;
use App\Entity\Stand;

class SearchDataCandidature
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
     * @var Annonce[]
     */
    public array $annonce = [];

    /**
     * @var Candidature[]
     */
    public array $statut = [];

    /**
     * @var Stand[]
     */
    public array $stands = [];

}