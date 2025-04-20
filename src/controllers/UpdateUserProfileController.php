<?php
require_once "../entity/UserProfile.php";

class UpdateUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Returns Success/Fail
    public function updateUserProfile($id, $role, $description, $isSuspend) {
        return $this->userProfile->updateUserProfile($id, $role, $description, $isSuspend);
    }
}

// `updateUserProfile.php` Script
// Executes when Update User Profile Form is Submitted (POST Request)
if (isset($_POST['id']) && isset($_POST['role']) && isset($_POST['description']) && isset($_POST['isSuspend'])) {
    
    $id = (int) $_POST['id'];
    $isSuspend = (int) $_POST['isSuspend'];

    // Instantiate New Login Controller & Authenticate User
    $controller = new UpdateUserProfileController();
    $status = $controller->updateUserProfile($id, $_POST['role'], $_POST['description'], $isSuspend);

    // CREATE SQL Statement Fail
    if ($status) {
        header("Location: ../updateUserProfile.php?id=$id&status=1");
        exit();
    
    } else {
        header("Location: ../updateUserProfile.php?id=$id&status=0");
        exit();
    }
} else {
    $_POST['id'] = (int) $_POST['id'];
    $id = $_POST['id'];
    header("Location: ../updateUserProfile.php?id=$id&status=0");
    exit();
}

?>