<?php

require_once("/var/www/html/entity/CleanerService.php");

class ViewAllCleanerServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function viewAllCleanerService(int $cleanerID): ?array
    {
        return $this->cleanerService->viewAllCleanerService($cleanerID);
    }
}