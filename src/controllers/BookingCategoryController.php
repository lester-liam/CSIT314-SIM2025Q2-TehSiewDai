<?php

require_once("/var/www/html/entity/ServiceHistory.php");

class BookingCategoryController
{
    private $serviceHistory;

    public function __construct()
    {
        $this->serviceHistory = new ServiceHistory();
    }

    public function getHoCategories(int $homeownerID): ?array
    {
        return $this->serviceHistory->getHoCategories($homeownerID);
    }
}