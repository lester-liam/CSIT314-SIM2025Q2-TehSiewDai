<?php
require_once "entity/ServiceCategory.php";

class ViewServiceCategoryController {
    
    private $serviceCategory;

    public function __construct() {
        $this->serviceCategory = new ServiceCategory();
    }

    // Returns Service Category
    public function readServiceCategory($id) {
        return $this->serviceCategory->readServiceCategory($id);
    }
}

?>