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
  <title>Create User Profile</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-left">
      <img src='img/cleaning-logo.png' alt="Cleaning Logo" width='48px' height='48px'/>
      <a href="viewUserProfile.php" class="active">User Profile</a>
      <a href="viewUserAccount.php">User Account</a>
    </div>
    <div class="navbar-right">
      <span class="navbar-right-text">Logged in as,<br/>
        (<?php echo htmlspecialchars($_SESSION["userProfile"]); ?>)
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
      </span>
      <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>

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
    // Form Validation
    const form = document.querySelector("form");

    // Submit Button Event
    document.getElementById("submit-button").addEventListener("click", function (event) {
      event.preventDefault();

      let isValid = true;

      // Role Validation: Not NULL
      const roleInput = document.getElementById('role');
      const trimmedRole = roleInput.value.trim();
      if (!trimmedRole) {
        document.getElementById('roleValidation').innerText = "Role cannot be empty";
        isValid = false;
      } else {
        document.getElementById('roleValidation').innerText = "";
      }

      // Description Validation: Not NULL
      const descriptionInput = document.getElementById('description');
      const trimmedDescription = descriptionInput.value.trim();
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