<?php
require_once "entity/UserProfile.php";

class SearchUserProfileController {
    
    private $userProfile;

    public function __construct() {
        $this->userProfile = new UserProfile();
    }

    // Search User Profile
    public function searchUserProfile($searchTerm) {
        return $this->userProfile->searchUserProfile($searchTerm);
    }
}

?>