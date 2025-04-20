<?php
require_once "entity/UserProfile.php";

class ViewUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Returns All User Account
    public function readAllUserProfile() {
        return $this->userProfile->readAllUserProfile();
    }

    // Returns All User Account
    public function readUserProfile($id) {
        return $this->userProfile->readUserProfile($id);
    }
}

?>