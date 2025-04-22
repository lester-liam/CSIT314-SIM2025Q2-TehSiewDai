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
  <title>Create User Profile</title>
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <!-- Navbar -->
  <!-- Navbar -->
  <nav class="navbar">
    <ul>
      <li><a href="viewUserProfile.php" id="selected">User Profile</a></li>
      <li><a href="viewUserAccount.php">User Account</a></li>
    </ul>
    <div class="logout-button">
      <button class="logout-button" onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <!-- info -->
  <div class="form-container">
    <h2>Create User Profile</h2>
    <br>
    <form action="controllers/CreateUserProfileController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert-danger" role="alert">
          <strong>Create User Profile Failed: Try a Different Role Name </strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert-success" role="alert">
          <strong>Successfully Created User Profile </strong>
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required>
        <span id='roleValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required>
        <span id='descValidation' class='text-danger'></span>
      </div>

      <div class="submit-row">
        <a href="viewUserProfile.php" class="back-button">Back</a>
        <button type="submit" id="submit-button" class="submit-button">Create</button>
      </div>
    </form>
  </div>
  
  
  <!-- Javascript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    const form = document.querySelector("form");

    // Prevent form submission on button click and handle validation
    document.getElementById("submit-button").addEventListener("click", function (event) {
      event.preventDefault(); // Prevent the default form submission

      const roleInput = document.getElementById('role');
      const descriptionInput = document.getElementById('description');

      const trimmedRole = roleInput.value.trim();
      const trimmedDescription = descriptionInput.value.trim();

      let isValid = true;

      if (!trimmedRole) {
        document.getElementById('roleValidation').innerText = "Role cannot be empty";
        isValid = false;
      } else {
        document.getElementById('roleValidation').innerText = "";
      }

      if (!trimmedDescription) {
        document.getElementById('descValidation').innerText = "Description cannot be empty";
        isValid = false;
      } else {
        document.getElementById('descValidation').innerText = "";
      }

      if (isValid) {
        if (confirm("Confirm Create User Profile?") == true) {
          form.submit();
        }
      }
    });
  </script>
</body>
</html>