<?php
require_once "entity/UserProfile.php";

class SearchUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Search User Account, Return Array[0 to Many] of User Profiles
    public function searchUserProfile($searchTerm) {
        return $this->userProfile->searchUserProfile($searchTerm);
    }
    
}

?>