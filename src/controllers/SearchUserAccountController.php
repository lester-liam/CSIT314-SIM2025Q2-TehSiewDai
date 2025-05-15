<?php

require_once("/var/www/html/entity/UserAccount.php");

class SearchUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function searchUserAccount(string $searchTerm): ?array
    {
        return $this->userAccount->searchUserAccount($searchTerm);
    }
}