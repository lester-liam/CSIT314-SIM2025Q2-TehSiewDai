<?php

require_once("/var/www/html/entity/ServiceHistory.php");

class ViewMatchesController
{
    private $serviceHistory;

    public function __construct()
    {
        $this->serviceHistory = new ServiceHistory();
    }

    public function viewMatches(int $cleanerID): ?array
    {
        return $this->serviceHistory->viewMatches($cleanerID);
    }
}