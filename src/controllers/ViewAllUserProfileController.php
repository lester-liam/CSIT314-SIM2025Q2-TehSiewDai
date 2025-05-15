<?php

require_once ("/var/www/html/entity/UserProfile.php");

class ViewAllUserProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function readAllUserProfile(): ?array
    {
        return $this->userProfile->readAllUserProfile();
    }
}