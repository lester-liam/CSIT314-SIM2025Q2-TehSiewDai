<?php
require_once "../entity/UserProfile.php";

session_start();

class SuspendUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Suspend User Profile, Returns a Boolean Value (Success/Fail)
    public function suspendUserProfile($id) {
        return $this->userProfile->suspendUserProfile($id);
    }

}

// `updateUserAccount.php` Script
// Executes when Suspend User Profile Button is Click (GET Request)
if (isset($_GET['id'])) {
    
    // Convert ID to Integer Value
    $id = (int) $_GET['id'];
    
    // Instantiate New Controller & Suspend User
    $controller = new SuspendUserProfileController();
    $status = $controller->suspendUserProfile($id);

    // Display Success or Fail
    if ($status) {
        header("Location: ../updateUserProfile.php?id=$id&status=1");
        exit();
    
    } else {
        header("Location: ../updateUserProfile.php?id=$id&status=0");
        exit();
    }
    
} else {

    $id = (int) $_GET['id'];
    header("Location: ../updateUserProfile.php?id=$id&status=0");
    exit();

}

?>