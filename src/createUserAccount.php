<?php

// Start the session (if not already started)
session_start();

// Ensure User is Logged In
if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
    header("Location: login.php");
    exit();
}

// Ensure User is Admin
if ($_SESSION['userProfile'] != "User Admin") {
     // If not, redirect them to a non-admin page or display an error
     header("Location: login.php"); // Replace with your unauthorized page
     exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create User Account</title>

  <style>
    * {
      margin: 0px;
      padding: 0px;
      box-sizing: border-box;
      font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    body {
      height: 100vh;
      background-color: rgb(233, 239, 236);
    }

    .navbar {
      width: 100%;
      height: 60px;
      background-color: rgb(22, 66, 60);
      padding: 15px 105px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar ul {
      list-style: none;
      gap: 40px;
      display: flex;
      margin-left: 20px;
    }

    .navbar ul li {
      position: relative;
    }

    .navbar ul li a {
      color: rgb(252, 252, 252);
      text-decoration: none;
      font-size: 18px;
      transition: 0.2s ease;
    }

    .navbar ul li a::before {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      left: 0px;
      bottom: -5px;
      background: rgb(255, 255, 255);
      transition: 0.2s ease;
    }

    .navbar ul li a:hover {
      color: rgb(255, 255, 255);
    }

    .navbar ul li a:hover::before {
      width: 100%;
    }

    .logout-button button {
      font-size: 18px;
      padding: 7px 15px;
      background-color: rgb(52, 91, 76);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.2s ease;
    }

    .logout-button button:hover {
      background-color: rgb(106, 156, 137);
    }

    .form-container {
      position: relative;
      width: 540px;
      height: auto;
      max-width: 600px;
      margin: auto;
      margin-top: 180px;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: rgb(22, 66, 60);
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      color: rgb(22, 66, 60);
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 6px;
    }

    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 6px;
      font-size: 1em; /* Adjust font size as needed */
      color: #333; /* Adjust text color */
      appearance: none; /* Remove default arrow */
    }

    .form-group select option {
      padding: 8px;
      font-size: 1em;
      color: #333;
      background-color: white; /* Ensure white background for options */
    }

    .form-group select:focus {
      border-color: rgb(22, 66, 60);
      outline: none; /* Remove default focus outline */
      box-shadow: 0 0 5px rgba(22, 66, 60, 0.5); /* Add a subtle focus shadow */
    }

    .radio-group {
      display: flex;
      align-items: center;
      gap: 30px;
      accent-color:  rgb(22, 66, 60);
    }

    .submit-row {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 30px;
    }

    .submit-button {
      flex: 1;
      background-color: rgb(22, 66, 60);
      color: white;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .submit-button:hover {
      background-color: rgb(106, 156, 137);
    }

    .back-button {
      flex: 1;
      background-color: white;
      color: rgb(22, 66, 60);
      border: 2px solid rgb(22, 66, 60);
      border-radius: 6px;
      padding: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.2s ease;
      text-align: center;
      text-decoration: none;
    }

    .back-button:hover {
      background-color: rgb(233, 239, 236);
    }
  </style>

</head>

<body>
  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <ul>
      <li><a href="viewUserProfile.php">User Profile</a></li>
      <li><a href="viewUserAccount.php" id="selected">User Account</a></li>
    </ul>
    <div class="logout-button">
      <button onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <!-- info -->
  <div class="form-container">
    <h2>Create User Account</h2>
    <br>
    <form action="controllers/CreateUserAccountController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert alert-danger" role="alert">
          <strong>Create User Account Failed: Try a Different Username</strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert alert-success" role="alert">
          <strong>Successfully Created User Account</strong>
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <span id='usernameValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <span id='passwdValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
        <span id='fullNameValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <span id='emailValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="phone">Phone (SG)</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{8}" placeholder="Eg: 00000000" required>
        <span id='phoneValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="role">Role:</label>
        <select class="form-select" id="floatingUserProfile" name="userProfile">
          <option value="Homeowner" selected>Homeowner</option>
          <option value="Cleaner">Cleaner</option>
          <option value="Platform Management">Platform Management</option>
          <option value="User Admin">User Admin</option>
        </select>
      </div>

      <div class="submit-row">
        <button onclick="window.location.href='viewUserAccount.php'" class="back-button">Back</button>
        <button type="submit" id="submit-button" class="submit-button">Create</button>
      </div>
    </form>
  </div>
  
  
  <!-- Javascript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    const form = document.querySelector("form");

    document.getElementById("submit-button").addEventListener("click", function (event) {
        event.preventDefault();

        let isValid = true;

        // Username Validation: No Whitespace or NULL after trim
        const usernameInput = document.getElementById('username');
        const trimmedUsername = usernameInput.value.trim();
        if (!trimmedUsername || trimmedUsername.includes(' ')) {
            document.getElementById('usernameValidation').innerText = "Username cannot be empty or contain spaces.";
            isValid = false;
        } else {
            document.getElementById('usernameValidation').innerText = "";
        }

        // Password Validation: No Whitespace or NULL after trim
        const passwordInput = document.getElementById('password');
        const trimmedPassword = passwordInput.value.trim();
        if (!trimmedPassword) {
            document.getElementById('passwdValidation').innerText = "Password cannot be empty, or contain spaces.";
            isValid = false;
        } else if (trimmedPassword.length < 8){
            document.getElementById('passwdValidation').innerText = "Password must be at least 8 characters";
            isValid = false;
        } else {
            document.getElementById('passwdValidation').innerText = "";
        }

        // Full Name Validation: Apply Title Case after trim
        const fullNameInput = document.getElementById('fullName');
        const trimmedFullName = fullNameInput.value.trim();
        if (!trimmedFullName) {
            document.getElementById('fullNameValidation').innerText = "Full Name cannot be empty.";
            isValid = false;
        } else {
            const titleCaseFullName = trimmedFullName.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            fullNameInput.value = titleCaseFullName; // Update the input value to title case
            document.getElementById('fullNameValidation').innerText = "";
        }

        // Email Validation: Basic check for @ and .
        const emailInput = document.getElementById('email');
        const trimmedEmail = emailInput.value.trim();
        if (!trimmedEmail) {
            document.getElementById('emailValidation').innerText = "Email cannot be empty.";
            isValid = false;
        } else if (!trimmedEmail.includes('@') || !trimmedEmail.includes('.')) {
            document.getElementById('emailValidation').innerText = "Please enter a valid email format (e.g., user@example.com).";
            isValid = false;
        } else {
            document.getElementById('emailValidation').innerText = "";
        }

        // Phone Validation (SG): 8 digits
        const phoneInput = document.getElementById('phone');
        const trimmedPhone = phoneInput.value.trim();
        const phoneRegex = /^[0-9]{8}$/;
        if (!trimmedPhone) {
            document.getElementById('phoneValidation').innerText = "Phone number cannot be empty.";
            isValid = false;
        } else if (!phoneRegex.test(trimmedPhone)) {
            document.getElementById('phoneValidation').innerText = "Please enter a valid 8-digit Singapore phone number.";
            isValid = false;
        } else {
            document.getElementById('phoneValidation').innerText = "";
        }

        if (isValid) {
          form.submit();
        }
    });
  </script>
</body>
</html>