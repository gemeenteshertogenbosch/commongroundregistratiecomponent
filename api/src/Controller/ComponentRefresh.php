<?php
// api/src/Controller/ComponentController.php

namespace App\Controller;

use App\Service\ComponentService;
use App\Entity\Component;

class ComponentRefresh  
{
    private $componentService;
    
    public function __construct(ComponentService $componentService)
    {
        $this->componentService = $componentService;
    }
    
    public function __invoke(Component $data): Component
    {
        $data = $this->componentService->refresh($data);
        
        return $data;
    }
}