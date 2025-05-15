<?php

require_once("/var/www/html/entity/UserAccount.php");

session_start();

class LoginController
{
    public function login(
        string $username,
        string $password,
        string $userProfile,
        ?PDO $mockDb
    ): ?UserAccount {
        $userAccount = new UserAccount();
        return $userAccount->login($username, $password, $userProfile, $mockDb);
    }
}

/**
 * Script to handle the submission of Login Form
 * Expects a POST request with 'username', 'password' and 'userProfile'
 */
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userProfile'])) {

    // Instantiate New Login Controller
    $controller = new LoginController();
    $userAccount = $controller->login(
        $_POST['username'],
        $_POST['password'],
        $_POST['userProfile'],
        null);

    // Null User: Display Invalid Credentials Error
    if (is_null($userAccount)) {
        header("Location: ../login.php?error=Invalid Credentials.");
        exit();
    // Suspended User: Display User Suspended Error
    } elseif (($userAccount->getSuspendStatus()) == 1) {
        header("Location: ../login.php?error=User Suspended");
        exit();
    } else {
        // Set Session Variables
        $_SESSION['id'] = $userAccount->getId();
        $_SESSION['username'] = $userAccount->getUsername();
        $_SESSION['userProfile'] = $userAccount->getUserProfile();

        // Redirecting to User's Main Page
        if ($_SESSION['userProfile'] == "User Admin") {
            header("Location: ../viewUserProfile.php");
            exit();
        } elseif ($_SESSION['userProfile'] == "Platform Management") {
            header("Location: ../viewServiceCategory.php");
            exit();
        } elseif ($_SESSION['userProfile'] == "Cleaner") {
            header("Location: ../viewCleanerService.php");
            exit();
        } else {
            header("Location: ../homeownerHome.php");
            exit();
        }
    }
}