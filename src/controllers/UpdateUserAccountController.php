<?php

require_once("/var/www/html/entity/UserAccount.php");

class UpdateUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function updateUserAccount(
        int $id,
        string $username,
        ?string $password,
        string $fullName,
        string $email,
        string $phone,
        string $userProfile
    ): bool {
        return $this->userAccount->updateUserAccount(
            $id,
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
 * Script to handle the submission of the Update User Account form.
 * Expects a POST request with `id`, 'username', 'password', 'fullName',
 * 'email', 'phone' and 'userProfile'
 */
if (
    isset($_POST['id']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['fullName']) &&
    isset($_POST['email']) &&
    isset($_POST['phone']) &&
    isset($_POST['userProfile'])
    ) {
        // Convert String ID to integer
        $id = (int) $_POST['id'];

        // Instantiate New Controller
        $controller = new UpdateUserAccountController();

        // If password is empty, pass 'null' to Controller for default value in Entity
        if ($_POST['password'] === "") {
            $status = $controller->updateUserAccount(
                $id,
                $_POST['username'],
                null,
                $_POST['fullName'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['userProfile']
            );
        } else {
            $status = $controller->updateUserAccount(
                $id,
                $_POST['username'],
                $_POST['password'],
                $_POST['fullName'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['userProfile']
            );
        }

        // Redirect back to the form with status message
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