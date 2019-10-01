<?php
// api/src/Controller/OrganisationController.php

namespace App\Controller;
use App\Service\OrganisationService;
use App\Entity\Organisation;

class OrganisationRefresh
{
    private $organisationService;
    
    public function __construct(OrganisationService $organisationService)
    {
        $this->organisationService = $organisationService;
    }
    
    public function __invoke(Organisation $data): Organisation
    {
        $this->organisationService->refresh($data);
        
        return $data;
    }
}