<?php

require_once("/var/www/html/entity/UserAccount.php");

class CreateUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function createUserAccount(
        string $username,
        string $password,
        string $fullName,
        string $email,
        string $phone,
        string $userProfile
    ): bool {
        return $this->userAccount->createUserAccount(
            $username,
            $password,
            $fullName,
            $email,
            $phone,
            $userProfile
        );
    }
}

/**
 * Script to handle the submission of the Create Service Category form.
 * Expects a POST request with 'username', 'password', 'fullname', 'email'
 * 'phone' and 'userProfile' parameters.
 */
if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['fullName']) &&
    isset($_POST['email']) &&
    isset($_POST['phone']) &&
    isset($_POST['userProfile'])
) {
    // Instantiate New Controller
    $controller = new CreateUserAccountController();
    $status = $controller->createUserAccount(
        $_POST['username'],
        $_POST['password'],
        $_POST['fullName'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['userProfile']
    );

    // Redirect back to the form with status message
    if ($status) {
        header("Location: ../createUserAccount.php?status=1");
        exit();
    } else {
        header("Location: ../createUserAccount.php?status=0");
        exit();
    }
}