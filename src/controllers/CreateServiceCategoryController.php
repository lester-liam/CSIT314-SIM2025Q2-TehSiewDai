<?php
require_once '../entity/ServiceCategory.php';

class CreateServiceCategoryController {

    private $serviceCategory;

    public function __construct() {
        $this->serviceCategory = new ServiceCategory();
    }

    // Update User Account, Returns Boolean Value (Success/Fail)
    public function createServiceCategory($category, $description) {
        return $this->serviceCategory->createServiceCategory($category, $description);
    }

}

// `updateServiceCategory.php` Script
// Executes when Update Service Category Form is Submitted (POST Request)
if (isset($_POST['category']) && isset($_POST['description'])) {

    // Instantiate New Controller & Update User Account
    $controller = new CreateServiceCategoryController();

    // If password is empty, replace password with null value
    // Entity will not update password field is password is NULL
    if ($_POST['description'] === "") {
        $status = $controller->createServiceCategory($_POST['category'], null);
    } else {
        $status = $controller->createServiceCategory($_POST['category'], $_POST['description']);
    }

    // Display Success or Fail
    if ($status) {
        header("Location: ../createServiceCategory.php?status=1");
        exit();

    } else {
        header("Location: ../createServiceCategory.php?status=0");
        exit();
    }

} else {

    header("Location: ../createServiceCategory.php?status=0");
    exit();

}

?>
