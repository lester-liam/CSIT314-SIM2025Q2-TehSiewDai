<?php

session_start();

// Check if User is Logged In
if (
    !isset($_SESSION['id']) &&
    !isset($_SESSION['username']) &&
    !isset($_SESSION['userProfile'])
) {
    header("Location: login.php");
    exit();
}

// UserProfile is Valid
if ($_SESSION['userProfile'] != "User Admin") {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create User Account</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-left">
      <img src='img/cleaning-logo.png' alt="Cleaning Logo" width='48px' height='48px'/>
      <a href="viewUserProfile.php">User Profile</a>
      <a href="viewUserAccount.php" class="active">User Account</a>
    </div>
    <div class="navbar-right">
      <span class="navbar-right-text">Logged in as,<br/>
        (<?php echo htmlspecialchars($_SESSION["userProfile"]); ?>)
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
      </span>
      <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>

  <!-- Form -->
  <div class="form-container">
    <h2>Create User Account</h2>
    <br>
    <form action="controllers/CreateUserAccountController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert-danger" role="alert">
          <strong>Create User Account Failed: Try a Different Username</strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert-success" role="alert">
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
        <input type="tel"
               id="phone"
               name="phone"
               pattern="[0-9]{8}"
               placeholder="Eg: 00000000"
               required>
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
        <button onclick="window.location.href='viewUserAccount.php'"
                class="back-button">Back</button>
        <button type="submit" id="submit-button" class="submit-button">Create</button>
      </div>
    </form>
  </div>

  <!-- Javascript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    // Form Validation
    const form = document.querySelector("form");

    // Submit Button Event
    document.getElementById("submit-button").addEventListener("click", function (event) {
        event.preventDefault();

        let isValid = true;

        // Username Validation: Not NULL
        const usernameInput = document.getElementById('username');
        const trimmedUsername = usernameInput.value.trim();
        if (!trimmedUsername || trimmedUsername.includes(' ')) {
            document.getElementById('usernameValidation').innerText =
              "Username cannot be empty or contain spaces.";
            isValid = false;
        } else {
            document.getElementById('usernameValidation').innerText = "";
        }

        // Password Validation: Not NULL, At least 8 or more Characters
        const passwordInput = document.getElementById('password');
        const trimmedPassword = passwordInput.value.trim();
        if (!trimmedPassword) {
            document.getElementById('passwdValidation').innerText =
              "Password cannot be empty, or contain spaces.";
            isValid = false;
        } else if (trimmedPassword.length < 8){
            document.getElementById('passwdValidation').innerText =
              "Password must be at least 8 characters";
            isValid = false;
        } else {
            document.getElementById('passwdValidation').innerText = "";
        }

        // Full Name Validation: Not NULL, Auto Apply Title Case
        const fullNameInput = document.getElementById('fullName');
        const trimmedFullName = fullNameInput.value.trim();
        if (!trimmedFullName) {
            document.getElementById('fullNameValidation').innerText =
              "Full Name cannot be empty.";
            isValid = false;
        } else {
            const titleCaseFullName = trimmedFullName
              .toLowerCase()
              .split(' ')
              .map(word => word.charAt(0).toUpperCase() + word.slice(1))
              .join(' ');
            fullNameInput.value = titleCaseFullName;
            document.getElementById('fullNameValidation').innerText = "";
        }

        // Email Validation: Not NULL, Basic Check for @ and '.'
        const emailInput = document.getElementById('email');
        const trimmedEmail = emailInput.value.trim();
        if (!trimmedEmail) {
            document.getElementById('emailValidation').innerText =
              "Email cannot be empty.";
            isValid = false;
        } else if (!trimmedEmail.includes('@') || !trimmedEmail.includes('.')) {
            document.getElementById('emailValidation').innerText =
              "Please enter a valid email format (e.g., user@example.com).";
            isValid = false;
        } else {
            document.getElementById('emailValidation').innerText = "";
        }

        // Phone Validation (SG): Not NULL, Exactly 8 Digits
        const phoneInput = document.getElementById('phone');
        const trimmedPhone = phoneInput.value.trim();
        const phoneRegex = /^[0-9]{8}$/;
        if (!trimmedPhone) {
            document.getElementById('phoneValidation').innerText =
              "Phone number cannot be empty.";
            isValid = false;
        } else if (!phoneRegex.test(trimmedPhone)) {
            document.getElementById('phoneValidation').innerText =
              "Please enter a valid 8-digit Singapore phone number.";
            isValid = false;
        } else {
            document.getElementById('phoneValidation').innerText = "";
        }

        if (isValid) {
          if (confirm("Confirm Create User Account?") == true) {
            form.submit();
        }
      }
    });
  </script>
</body>
</html>