<?php

namespace App\Controllers;

use App\Services\CleaningOverridesService;

class CleaningOverridesController
{
    protected CleaningOverridesService $service;

    public function __construct() {
        $this->service = new CleaningOverridesService();
    }
    
    public function index()
    {
        // ...
    }
}