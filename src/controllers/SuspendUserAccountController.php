<?php
require_once "../entity/UserAccount.php";

session_start();

class SuspendUserAccountController {
    
    private $userAccount;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Suspend User Account, Returns a Boolean Value (Success/Fail)
    public function suspendUserAccount($id) {
        return $this->userAccount->suspendUserAccount($id);
    }

}

// `updateUserAccount.php` Script
// Executes when Suspend User Account Button is Click (GET Request)
if (isset($_GET['id'])) {
    
    // Convert ID to Integer Value
    $id = (int) $_GET['id'];
    
    // Instantiate New Controller & Suspend User
    $controller = new SuspendUserAccountController();
    $status = $controller->suspendUserAccount($id);

    // Display Success or Fail
    if ($status) {
        header("Location: ../updateUserAccount.php?id=$id&status=1");
        exit();
    
    } else {
        header("Location: ../updateUserAccount.php?id=$id&status=0");
        exit();
    }

} else {

    $id = (int) $_POST['id'];
    header("Location: ../updateUserAccount.php?id=$id&status=0");
    exit();
    
}

?>