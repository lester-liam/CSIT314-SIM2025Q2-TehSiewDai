<?php

require_once("/var/www/html/entity/UserProfile.php");

class ViewUserProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function readUserProfile(int $id): ?UserProfile
    {
        return $this->userProfile->readUserProfile($id);
    }
}