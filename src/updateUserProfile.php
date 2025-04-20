<?php

// Start the session (if not already started)
session_start();

// Include the controller
require_once 'controllers/ViewUserProfileController.php';

// Ensure User is Logged In
if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
    header("Location: login.php");
    exit();
}

// Ensure User is Admin
if ($_SESSION['userProfile'] != "User Admin") {
     header("Location: login.php");
     exit();
}

if (!isset($_GET['id'])) {
  header("Location: viewUserProfile.php");
  exit();
} else {
  // Instantiate the controller
  $controller = new ViewUserProfileController();

  // Get all user accounts
  $up = $controller->readUserProfile($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update User Info</title>

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

    input[readonly] {
      background-color: #e9ecef;
      color: #6c757d;
      cursor: not-allowed; 
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
      <li><a href="#">User Profile</a></li>
      <li><a href="#">User Account</a></li>
    </ul>
    <div class="logout-button">
      <button>Log out</button>
    </div>
  </nav>

  <!-- info -->
  <div class="form-container">
    <h2>Update User Info</h2>
    <br>
    <form action="controllers/UpdateUserProfileController.php" method="post">
    <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert alert-danger" role="alert">
          <strong>Update User Profile Failed: Try a Different Role Name </strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert alert-success" role="alert">
          <strong>Successfully Updated User Profile </strong>
        </div>
    <?php } ?>

      <div class="form-group">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($up['id']); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($up['role']); ?>"
        <?php if ($up['role'] == "User Admin" || $up['role'] == "Homeowner" || $up['role'] == "Cleaner" || $up['role'] == 'Platform Management') { echo 'readonly'; } ?>>
        <span id='roleValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($up['description']); ?>" required>
        <span id='descValidation' class='text-danger'></span>
      </div>

      <?php if ($up['isSuspend'] == 1) { ?>
      
        <div class="form-group radio-group">
        <label>Suspended:</label>
        <label><input type="radio" name="isSuspend" value="1" checked>&nbspYES</label>
        <label><input type="radio" name="isSuspend" value="0">&nbspNO</label>
        </div>
      
      <?php } else { ?>
      
        <div class="form-group radio-group">
        <label>Suspended:</label>
        <label><input type="radio" name="isSuspend" value="1">&nbspYES</label>
        <label><input type="radio" name="isSuspend" value="0" checked>&nbspNO</label>
        </div>

      <?php } ?>

      <div class="submit-row">
        <button type="button" onclick='window.location.href="viewUserProfile.php"' class="back-button">Back</button>
        <button type="submit" id="submit-button" class="submit-button">Update</button>
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
        form.submit();
      }
    });
  </script>
</body>
</html>