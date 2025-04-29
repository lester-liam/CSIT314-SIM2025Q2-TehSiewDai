<?php
require_once '../entity/ServiceCategory.php';

class UpdateServiceCategoryController {
    
    private $serviceCategory;

    public function __construct() {
        $this->serviceCategory = new ServiceCategory();
    }

    // Update User Account, Returns Boolean Value (Success/Fail)
    public function updateServiceCategory($id, $category, $description) {
        return $this->serviceCategory->updateServiceCategory($id, $category, $description);
    }
    
}

// `updateServiceCategory.php` Script
// Executes when Update Service Category Form is Submitted (POST Request)
if (isset($_POST['id']) && isset($_POST['category']) && isset($_POST['description'])) {
    
    // Convert string ID to integer
    $id = (int) $_POST['id'];

    // Instantiate New Controller & Update User Account
    $controller = new UpdateServiceCategoryController();
    
    // If password is empty, replace password with null value
    // Entity will not update password field is password is NULL
    if ($_POST['description'] === "") {
        $status = $controller->updateServiceCategory($id, $_POST['category'], null);
    } else {
        $status = $controller->updateServiceCategory($id, $_POST['category'], $_POST['description']);
    }
    
    // Display Success or Fail
    if ($status) {
        header("Location: ../updateServiceCategory.php?id=$id&status=1");
        exit();
    
    } else {
        header("Location: ../updateServiceCategory.php?id=$id&status=0");
        exit();
    }

} else {

    $id = (int) $_POST['id'];
    header("Location: ../updateServiceCategory.php?id=$id&status=0");
    exit();

}

?>
