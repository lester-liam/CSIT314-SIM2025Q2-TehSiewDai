<?php
require_once "entity/UserAccount.php";

class ViewUserAccountController {

    private $userAccount;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Returns All User Account
    public function readAllUserAccount() {
        return $this->userAccount->readAllUserAccount();
    }

    // Returns All User Account
    public function readUserAccount($id) {
        return $this->userAccount->readUserAccount($id);
    }
}

?>