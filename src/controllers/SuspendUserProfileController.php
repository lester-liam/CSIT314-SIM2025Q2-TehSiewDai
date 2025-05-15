<?php

require_once("/var/www/html/entity/UserProfile.php");

class SuspendUserProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function suspendUserProfile(int $id): bool
    {
        return $this->userProfile->suspendUserProfile($id);
    }
}

/**
 * Script to handle the request of Suspend User Profile
 * Expects a GET request with 'id'
 */
if (isset($_GET['id'])) {
    // Convert String ID to Integer Value
    $id = (int) $_GET['id'];

    // Instantiate New Controller
    $controller = new SuspendUserProfileController();
    $status = $controller->suspendUserProfile($id);

    // Redirect back to the form with status message
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