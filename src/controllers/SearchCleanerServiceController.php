<?php

require_once("/var/www/html/entity/CleanerService.php");

class SearchCleanerServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function searchCleanerService(int $cleanerID, string $searchTerm): ?array
    {
        return $this->cleanerService->searchCleanerService($cleanerID, $searchTerm);
    }
}