<?php

require_once("/var/www/html/entity/ServiceHistory.php");

class SearchBookingsController
{
    private $serviceHistory;

    public function __construct()
    {
        $this->serviceHistory = new ServiceHistory();
    }

    public function searchBookings(
        int $homeownerID,
        string $category,
        int $dateOption
    ): ?array {
        return $this->serviceHistory->searchBookings(
            $homeownerID,
            $category,
            $dateOption
        );
    }
}