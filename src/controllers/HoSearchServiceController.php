<?php

require_once("/var/www/html/entity/CleanerService.php");

class HoSearchServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function hoSearchService(string $searchTerm): ?array
    {
        return $this->cleanerService->hoSearchService($searchTerm);
    }
}