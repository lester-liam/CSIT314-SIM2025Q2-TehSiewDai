<?php
session_start();

include '../entity/User.php';

class LoginController {
    private $userProfile;
    private $username;
    private $password;

    // Constructor to initialize the class with user data
    public function __construct($userProfile, $username, $password) {
        
        $this->userProfile = $userProfile;
        $this->username = $username;
        $this->password = md5($password);
    
    }

    // Method to authenticate user and set session
    public function login() {
        // Call the User class' login method to authenticate
        $userClass = new User($this->username, null, $this->password, null, null, $this->userProfile, null);
        $user = $userClass->auth();
        return $user;
    }
}

// Executes when Login Form is Submitted
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userProfile'])) {
    
    // Create a new LoginController instance and authenticate
    $loginControl = new LoginController($_POST['userProfile'], $_POST['username'], $_POST['password']);
    $user = $loginControl->login();

    // If authentication fails, redirect back to the login page with an error
    if ($user['id'] == -1) {
        header("Location: ../login.php?error=Invalid credentials");
        exit();
    } else {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['userProfile'] = $user['userProfile'];
        header("Location: ../dashboard.php");
        exit();
    }
}
?>
