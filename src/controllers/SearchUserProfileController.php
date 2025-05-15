<?php

require_once("/var/www/html/entity/UserProfile.php");

class SearchUserProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function searchUserProfile(string $searchTerm): ?array
    {
        return $this->userProfile->searchUserProfile($searchTerm);
    }
}