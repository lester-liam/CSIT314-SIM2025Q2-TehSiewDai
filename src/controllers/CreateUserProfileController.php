<?php
require_once "../entity/UserProfile.php";

class CreateUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Returns Success/Fail
    public function createUserProfile($role, $description) {
        return $this->userProfile->createUserProfile($role, $description);
    }
}

// `createUserProfile.php` Script
// Executes when Create User Profile Form is Submitted (POST Request)
if (isset($_POST['role']) && isset($_POST['description'])) {
    
    // Instantiate New Login Controller & Authenticate User
    $controller = new CreateUserProfileController();
    $status = $controller->createUserProfile($_POST['role'], $_POST['description']);

    if ($status) {
        header("Location: ../createUserProfile.php?status=1");
        exit();
    } else {
        header("Location: ../createUserProfile.php?status=0");
        exit();
    }
        

}
s
?>