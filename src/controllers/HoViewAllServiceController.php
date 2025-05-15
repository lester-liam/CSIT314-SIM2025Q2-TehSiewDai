<?php

require_once("/var/www/html/entity/CleanerService.php");

class HoViewAllServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function hoViewAllService(): ?array
    {
        return $this->cleanerService->hoViewAllService();
    }
}