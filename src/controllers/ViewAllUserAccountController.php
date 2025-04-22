<?php
require_once "entity/UserAccount.php";

class ViewAllUserAccountController {

    private $userAccount;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Returns All User Account
    public function readAllUserAccount() {
        return $this->userAccount->readAllUserAccount();
    }
}

?>