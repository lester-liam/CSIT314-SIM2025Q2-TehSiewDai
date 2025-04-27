<?php
require_once "entity/ServiceCategory.php";

class ViewAllServiceCategoryController {
    
    private $serviceCategory;

    public function __construct() {
        $this->serviceCategory = new ServiceCategory();
    }

    // Returns All Service Category
    public function readAllServiceCategory() {
        return $this->serviceCategory->readAllServiceCategory();
    }
}

?>