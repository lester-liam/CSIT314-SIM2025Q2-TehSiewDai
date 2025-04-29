<?php
require_once "../entity/UserAccount.php";

class UpdateUserAccountController {
    
    private $userAccount;

    public function __construct() {
        $this->userAccount = new UserAccount();
    }

    // Update User Account, Returns Boolean Value (Success/Fail)
    public function updateUserAccount($id, $username, $password, $fullName, $email, $phone, $userProfile) {
        return $this->userAccount->updateUserAccount($id, $username, $password, $fullName, $email, $phone, $userProfile);
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
    isset($_POST['userProfile'])
    ) {
        
        // Convert string ID to integer
        $id = (int) $_POST['id'];

        // Instantiate New Controller & Update User Account
        $controller = new UpdateUserAccountController();

        // If password is empty, replace password with null value
        // Entity will not update password field is password is NULL
        if ($_POST['password'] === "") {
            $status = $controller->updateUserAccount($id, $_POST['username'], null, $_POST['fullName'], $_POST['email'], $_POST['phone'], $_POST['userProfile']);
        } else {
            $status = $controller->updateUserAccount($id, $_POST['username'], $_POST['password'], $_POST['fullName'], $_POST['email'], $_POST['phone'], $_POST['userProfile']);
        }
        
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