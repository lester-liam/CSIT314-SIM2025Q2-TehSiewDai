<?php

require_once("/var/www/html/entity/ServiceHistory.php");

class MatchCategoryController
{
    private $serviceHistory;

    public function __construct()
    {
        $this->serviceHistory = new ServiceHistory();
    }

    public function getCategories(int $cleanerID): ?array
    {
        return $this->serviceHistory->getCategories($cleanerID);
    }
}