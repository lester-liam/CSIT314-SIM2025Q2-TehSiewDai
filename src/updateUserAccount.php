<?php

session_start();

require_once 'controllers/ViewUserAccountController.php';

// Check if User is Logged In
if (
    !isset($_SESSION['id']) &&
    !isset($_SESSION['username']) &&
    !isset($_SESSION['userProfile'])
) {
    header("Location: login.php");
    exit();
}

// Check if UserProfile is Valid
if ($_SESSION['userProfile'] != "User Admin") {
    header("Location: login.php");
    exit();
}

// Check if GET['id' Parameter Exists
if (isset($_GET['id'])) {
  // Get User Account
  $controller = new ViewUserAccountController();
  $userAccount = $controller->readUserAccount($_GET['id']);
} else {
  header("Location: viewUserAccount.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update User Account</title>
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
    <h2>Update User Info</h2>
    <br>
    <form action="controllers/UpdateUserAccountController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert-danger" role="alert">
          <strong>Update User Account Failed: Try a Different Username</strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert-success" role="alert">
          <strong>Successfully Updated User Account</strong>
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="id">ID:</label>
        <input type="text"
               id="id"
               name="id"
               value="<?php echo htmlspecialchars($userAccount->getId()); ?>" readonly>
      </div>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text"
               id="username"
               name="username"
               value="<?php echo htmlspecialchars($userAccount->getUsername()); ?>" required>
        <span id='usernameValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password"
               id="password"
               name="password"
               placeholder="Leave blank to remain unchanged">
        <span id='passwdValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
        <label for="fullName">Full Name:</label>
        <input type="text"
               id="fullName"
               name="fullName"
               value="<?php echo htmlspecialchars($userAccount->getFullName()); ?>" required>
        <span id='fullNameValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email"
               id="email"
               name="email"
               value="<?php echo htmlspecialchars($userAccount->getEmail()); ?>" required>
        <span id='emailValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
        <label for="phone">Phone (SG)</label>
        <input type="tel"
               id="phone"
               name="phone"
               pattern="[0-9]{8}"
               placeholder="Eg: 00000000"
               value="<?php echo htmlspecialchars($userAccount->getPhone()); ?>" required>
        <span id='phoneValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
        <label for="userProfile">Role:</label>
        <input type="text"
               id="userProfile"
               name="userProfile"
               value="<?php echo htmlspecialchars($userAccount->getUserProfile()); ?>" readonly>
      </div>
      <!-- Disable/Enable Suspend Button -->
      <?php if ($userAccount->getSuspendStatus() == 1) { ?>
        <div class="form-group">
          <button type="button" class="suspend-button-disabled" disabled>Suspend</button>
        </div>
      <?php } else { ?>
        <div class="form-group">
          <button type="button" class="suspend-button" onclick="suspendButtonClicked()">Suspend</button>
        </div>
      <?php } ?>
      <div class="submit-row">
        <button type="button"
                onclick='window.location.href="viewUserAccount.php"'
                class="back-button">Back</button>
        <button type="submit" id="submit-button" class="submit-button">Update</button>
      </div>
    </form>
  </div>

  <!-- Javascript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    // Suspend Button Clicked
    function suspendButtonClicked() {
      if (confirm("Confirm Suspend User Account?") == true) {
        window.location.href='./controllers/SuspendUserAccountController.php?id=<?php echo htmlspecialchars($_GET['id']); ?>'
      }
    }

    // Form Validation
    const form = document.querySelector("form");
    document.getElementById("submit-button").addEventListener("click", function (event) {
        event.preventDefault();

        let isValid = true;

        // Username Validation: Not NULL
        const usernameInput = document.getElementById('username');
        const trimmedUsername = usernameInput.value.trim();
        if (!trimmedUsername || trimmedUsername.includes(' ')) {
            document.getElementById('usernameValidation').innerText = "Username cannot be empty or contain spaces.";
            isValid = false;
        } else {
            document.getElementById('usernameValidation').innerText = "";
        }

        // Password Validation: Not NULL, At least 8 characters
        const passwordInput = document.getElementById('password');
        const trimmedPassword = passwordInput.value.trim();

        if (trimmedPassword.length > 0 && trimmedPassword.length < 8) {
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
            fullNameInput.value = titleCaseFullName; // Update the input value to title case
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
            document.getElementById('phoneValidation').innerText = "Phone number cannot be empty.";
            isValid = false;
        } else if (!phoneRegex.test(trimmedPhone)) {
            document.getElementById('phoneValidation').innerText = "Please enter a valid 8-digit Singapore phone number.";
            isValid = false;
        } else {
            document.getElementById('phoneValidation').innerText = "";
        }

        if (isValid) {
          if (confirm("Confirm Update User Account?") == true) {
            form.submit();
          }
        }
    });
    </script>
</body>
</html>