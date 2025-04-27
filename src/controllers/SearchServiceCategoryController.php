<?php
require_once "entity/ServiceCategory.php";

class SearchServiceCategoryController {
    
    private $serviceCategory;

    public function __construct() {
        $this->serviceCategory = new ServiceCategory();
    }

    // Search User Account, Return Array[0 to Many] of User Profiles
    public function searchServiceCategory($searchTerm) {
        return $this->serviceCategory->searchServiceCategory($searchTerm);
    }
    
}

?>