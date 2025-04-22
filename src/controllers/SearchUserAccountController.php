<?php
require_once "entity/UserAccount.php";

class SearchUserAccountController {
    
    private $userAccount;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Search User Account, Return Array[0 to Many] of User Account
    public function searchUserAccount($searchTerm) {
        return $this->userAccount->searchUserAccount($searchTerm);
    }
}

?>