<?php

require_once("/var/www/html/entity/UserAccount.php");

class ViewUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function readUserAccount(int $id): ?UserAccount
    {
        return $this->userAccount->readUserAccount($id);
    }
}