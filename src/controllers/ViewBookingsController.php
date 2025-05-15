<?php

require_once("/var/www/html/entity/ServiceHistory.php");

class ViewBookingsController
{
    private $serviceHistory;

    public function __construct()
    {
        $this->serviceHistory = new ServiceHistory();
    }

    public function viewBookings(int $homeownerID): ?array
    {
        return $this->serviceHistory->viewBookings($homeownerID);
    }
}