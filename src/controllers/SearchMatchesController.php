<?php

require_once("/var/www/html/entity/ServiceHistory.php");

class SearchMatchesController
{
    private $serviceHistory;

    public function __construct()
    {
        $this->serviceHistory = new ServiceHistory();
    }

    public function searchMatches(
        int $cleanerID,
        string $category,
        int $dateOption
    ): ?array {
        return $this->serviceHistory->searchMatches(
                                        $cleanerID,
                                        $category,
                                        $dateOption
                                      );
    }
}