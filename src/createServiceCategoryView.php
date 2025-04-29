<?php
session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
    header("Location: login.php");
    exit();
}

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
  <title>Create Service Category</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar" id="navbar">
    <ul>
      <li><a href="viewServiceCategory.php" id="selected">Service Categories</a></li>
    </ul>
    <div class="logout-button">
      <button onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <div class="form-container">
    <h2>Create Service Category</h2>
    <br>
    <form action="controllers/CreateServiceCategoryController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert-danger" role="alert">
          <strong>Create Service Category Failed: Try a Different Name</strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert-success" role="alert">
          <strong>Successfully Created Service Category</strong>
        </div>
      <?php } ?>

      <div class="form-group">
        <label for="serviceName">Service Name:</label>
        <input type="text" id="serviceName" name="serviceName" required>
        <span id='nameValidation' class='text-danger'></span>
      </div>

      <div class="form-group">
        <label for="serviceCategory">Service Description:</label>
        <input type="text" id="serviceCategory" name="serviceCategory" required>
        <span id='descValidation' class='text-danger'></span>
      </div>

      <div class="submit-row">
        <button onclick="window.location.href='viewServiceCategory.php'" class="back-button">Back</button>
        <button type="submit" id="submit-button" class="submit-button">Create</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.querySelector("form");

    document.getElementById("submit-button").addEventListener("click", function (event) {
      event.preventDefault();
      let isValid = true;

      const nameInput = document.getElementById('serviceName');
      const trimmedName = nameInput.value.trim();
      if (!trimmedName) {
        document.getElementById('nameValidation').innerText = "Service Name cannot be empty.";
        isValid = false;
      } else {
        document.getElementById('nameValidation').innerText = "";
      }

      const descInput = document.getElementById('serviceCategory');
      const trimmedDesc = descInput.value.trim();
      if (!trimmedDesc) {
        document.getElementById('descValidation').innerText = "Service Description cannot be empty.";
        isValid = false;
      } else {
        document.getElementById('descValidation').innerText = "";
      }

      if (isValid) {
        if (confirm("Confirm Create Service Category?") == true) {
          form.submit();
        }
      }
    });
  </script>
</body>
</html>
