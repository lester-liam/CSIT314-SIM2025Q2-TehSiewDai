<?php

require_once("/var/www/html/entity/UserAccount.php");

class SuspendUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function suspendUserAccount(int $id): bool
    {
        return $this->userAccount->suspendUserAccount($id);
    }
}

/**
 * Script to handle the request of Suspend User Account
 * Expects a GET request with 'id'
 */
if (isset($_GET['id'])) {
    // Convert String ID to Integer Value
    $id = (int) $_GET['id'];

    // Instantiate New Controller
    $controller = new SuspendUserAccountController();
    $status = $controller->suspendUserAccount($id);

    // Redirect back to the form with status message
    if ($status) {
        header("Location: ../updateUserAccount.php?id=$id&status=1");
        exit();
    } else {
        header("Location: ../updateUserAccount.php?id=$id&status=0");
        exit();
    }
} else {
    $id = (int) $_GET['id'];
    header("Location: ../updateUserAccount.php?id=$id&status=0");
    exit();
}