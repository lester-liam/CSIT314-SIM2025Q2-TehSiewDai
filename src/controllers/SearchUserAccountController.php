<?php
require_once "entity/UserAccount.php";

class SearchUserAccountController {
    
    private $userAccount;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Search User Profile
    public function searchUserAccount($searchTerm) {
        return $this->userAccount->searchUserAccount($searchTerm);
    }
}

?>