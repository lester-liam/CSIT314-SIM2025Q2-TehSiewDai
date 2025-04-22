<?php
require_once "../entity/UserProfile.php";

class UpdateUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Update User Account, Returns Boolean Value (Success/Fail)
    public function updateUserProfile($id, $role, $description) {
        return $this->userProfile->updateUserProfile($id, $role, $description);
    }
    
}

// `updateUserProfile.php` Script
// Executes when Update User Profile Form is Submitted (POST Request)
if (isset($_POST['id']) && isset($_POST['role']) && isset($_POST['description'])) {
    
    // Convert string ID to integer
    $id = (int) $_POST['id'];

    // Instantiate New Controller & Update User Account
    $controller = new UpdateUserProfileController();
    $status = $controller->updateUserProfile($id, $_POST['role'], $_POST['description']);

    // Display Success or Fail
    if ($status) {
        header("Location: ../updateUserProfile.php?id=$id&status=1");
        exit();
    
    } else {
        header("Location: ../updateUserProfile.php?id=$id&status=0");
        exit();
    }

} else {

    $id = (int) $_POST['id'];
    header("Location: ../updateUserProfile.php?id=$id&status=0");
    exit();

}

?>