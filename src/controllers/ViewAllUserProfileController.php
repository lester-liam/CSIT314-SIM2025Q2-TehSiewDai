<?php
require_once "entity/UserProfile.php";

class ViewAllUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Returns All User Profiles
    public function readAllUserProfile() {
        return $this->userProfile->readAllUserProfile();
    }
}

?>