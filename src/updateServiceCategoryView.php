<?php
session_start();
require_once 'controllers/ViewServiceCategoriesController.php';

// Check login
if (!isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['userProfile'])) {
  header("Location: login.php");
  exit();
}

// Only admin can access
if ($_SESSION['userProfile'] != "User Admin") {
  header("Location: login.php");
  exit();
}

// Get category by ID
if (!isset($_GET['id'])) {
  header("Location: viewServiceCategories.php");
  exit();
} else {
  $controller = new ViewServiceCategoriesController();
  $sc = $controller->readServiceCategory($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Service Category</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar">
    <ul>
      <li><a href="viewServiceCategories.php" id="selected">Service Categories</a></li>
    </ul>
    <div class="logout-button">
      <button onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <div class="form-container">
    <h2>Update Service Category</h2>
    <br>
    <form action="controllers/UpdateServiceCategoriesController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert-danger" role="alert">
          <strong>Update Failed: Please Try Again</strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert-success" role="alert">
          <strong>Service Category Updated Successfully</strong>
        </div>
      <?php } ?>

      <div class="form-group">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($sc['id']); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="serviceName">Service Name:</label>
        <input type="text" id="serviceName" name="serviceName" value="<?php echo htmlspecialchars($sc['serviceName']); ?>" required>
        <span id='nameValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="serviceCategory">Service Description:</label>
        <input type="text" id="serviceCategory" name="serviceCategory" value="<?php echo htmlspecialchars($sc['serviceCategory']); ?>" required>
        <span id='categoryValidation' class='text-danger'></span>
      </div>

      <div class="submit-row">
        <button type="button" onclick='window.location.href="viewServiceCategories.php"' class="back-button">Back</button>
        <button type="submit" id="submit-button" class="submit-button">Update</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.querySelector("form");

    document.getElementById("submit-button").addEventListener("click", function (event) {
      event.preventDefault();
      let isValid = true;

      const serviceName = document.getElementById("serviceName").value.trim();
      if (!serviceName) {
        document.getElementById("nameValidation").innerText = "Service Name cannot be empty.";
        isValid = false;
      } else {
        document.getElementById("nameValidation").innerText = "";
      }

      const serviceCategory = document.getElementById("serviceCategory").value.trim();
      if (!serviceCategory) {
        document.getElementById("categoryValidation").innerText = "Service Description cannot be empty.";
        isValid = false;
      } else {
        document.getElementById("categoryValidation").innerText = "";
      }

      if (isValid) {
        if (confirm("Confirm update of Service Category?")) {
          form.submit();
        }
      }
    });
  </script>
</body>
</html>
