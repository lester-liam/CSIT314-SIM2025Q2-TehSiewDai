<?php

require_once ("/var/www/html/entity/UserAccount.php");

class ViewAllUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function readAllUserAccount(): ?array
    {
        return $this->userAccount->readAllUserAccount();
    }
}