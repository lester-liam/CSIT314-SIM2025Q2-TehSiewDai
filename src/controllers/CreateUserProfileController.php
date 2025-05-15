<?php

require_once("/var/www/html/entity/UserProfile.php");

class CreateUserProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function createUserProfile(string $role, string $description): bool
    {
        return $this->userProfile->createUserProfile($role, $description);
    }
}

/**
 * Script to handle the submission of the Create UserProfile form.
 * Expects a POST request with 'role' and 'description'
 */
if (isset($_POST['role']) && isset($_POST['description'])) {
    // Instantiate New Controller
    $controller = new CreateUserProfileController();
    $status = $controller->createUserProfile($_POST['role'], $_POST['description']);

    // Redirect back to the form with status message
    if ($status) {
        header("Location: ../createUserProfile.php?status=1");
        exit();
    } else {
        header("Location: ../createUserProfile.php?status=0");
        exit();
    }
}