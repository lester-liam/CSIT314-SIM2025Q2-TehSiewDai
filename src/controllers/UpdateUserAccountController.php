<?php
require_once "../entity/UserAccount.php";

class UpdateUserAccountController {
    
    private $userProfile;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Returns Success/Fail
    public function updateUserAccount($id, $username, $password, $fullName, $email, $phone, $userProfile, $isSuspend) {
        return $this->userAccount->updateUserAccount($id, $username, $password, $fullName, $email, $phone, $userProfile, $isSuspend);
    }
}

// `updateUserAccount.php` Script
// Executes when Update User Account Form is Submitted (POST Request)
if (
    isset($_POST['id']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['fullName']) &&
    isset($_POST['email']) &&
    isset($_POST['phone']) &&
    isset($_POST['userProfile']) &&
    isset($_POST['isSuspend'])
    ) {
    
        $id = (int) $_POST['id'];
        $isSuspend = (int) $_POST['isSuspend'];
        $controller = new UpdateUserAccountController();

        // Update User Account
        if ($_POST['password'] === "") {
            $status = $controller->updateUserAccount($id, $_POST['username'], null, $_POST['fullName'], $_POST['email'], $_POST['phone'], $_POST['userProfile'], $isSuspend);
        } else {
            $status = $controller->updateUserAccount($id, $_POST['username'], $_POST['password'], $_POST['fullName'], $_POST['email'], $_POST['phone'], $_POST['userProfile'], $isSuspend);
        }
        
        // Update SQL Statement Fail
        if ($status) {
            header("Location: ../updateUserAccount.php?id=$id&status=1");
            exit();
        
        } else {
            header("Location: ../updateUserAccount.php?id=$id&status=0");
            exit();
        }

} else {

    $_POST['id'] = (int) $_POST['id'];
    $id = $_POST['id'];
    header("Location: ../updateUserAccount.php?id=$id&status=0");
    exit();

}

?>