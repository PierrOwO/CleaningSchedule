<?php

namespace App\Controllers;

use App\Services\ReportService;

class ReportController
{
    protected ReportService $service;

    public function __construct() {
        $this->service = new ReportService();
    }

    public function index()
    {
        // ...
    }
    
}