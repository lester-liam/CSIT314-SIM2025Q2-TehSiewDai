<?php
require_once "../entity/ServiceCategory.php";

session_start();

class DeleteServiceCategoryController {
    
    private $serviceCategory;

    public function __construct() {
        $this->serviceCategory = new ServiceCategory();
    }

    // Suspend User Profile, Returns a Boolean Value (Success/Fail)
    public function deleteServiceCategory($id) {
        return $this->serviceCategory->deleteServiceCategory($id);
    }

}

// `updateUserAccount.php` Script
// Executes when Suspend User Profile Button is Click (GET Request)
if (isset($_GET['id'])) {
    
    // Convert ID to Integer Value
    $id = (int) $_GET['id'];
    
    // Instantiate New Controller & Suspend User
    $controller = new DeleteServiceCategoryController();
    $status = $controller->deleteServiceCategory($id);

    // Alert Success or Fail, then Redirect
    if ($status) { 

?>
    
        <script> alert ("Delete Successful"); window.location.href="../viewServiceCategory.php"; </script> 

<?php

    } else { ?> 
        
        <script> alert ("Delete Failed"); window.location.href="../viewServiceCategory.php"; </script> 
    
<?php
    
    }
    
    
} else { ?>
    
    <script> alert ("Delete Failed"); window.location.href="../viewServiceCategory.php"; </script> 

<?php } ?>