<?php

require_once("/var/www/html/entity/ServiceCategory.php");

class ViewAllServiceCategoryController
{
    private $serviceCategory;

    public function __construct()
    {
        $this->serviceCategory = new ServiceCategory();
    }

    public function readAllServiceCategory(): ?array
    {
        return $this->serviceCategory->readAllServiceCategory();
    }
}