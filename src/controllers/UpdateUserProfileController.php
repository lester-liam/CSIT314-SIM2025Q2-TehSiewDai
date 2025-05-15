<?php

require_once("/var/www/html/entity/UserProfile.php");

class UpdateUserProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function updateUserProfile(int $id, string $role, string $description): bool
    {
        return $this->userProfile->updateUserProfile($id, $role, $description);
    }
}

/**
 * Script to handle the submission of the Update User Profile Form.
 * Expects a POST request with `id`, 'role' and 'description'
 */
if (isset($_POST['id']) && isset($_POST['role']) && isset($_POST['description'])) {
    // Convert String ID to Integer
    $id = (int) $_POST['id'];

    // Instantiate New Controller
    $controller = new UpdateUserProfileController();
    $status = $controller->updateUserProfile($id, $_POST['role'], $_POST['description']);

    // Redirect back to the form with status message
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