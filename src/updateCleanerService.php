<?php

session_start();

require_once 'controllers/ViewCleanerServiceController.php';

// User is Logged In
if (
    !isset($_SESSION['id']) &&
    !isset($_SESSION['username']) &&
    !isset($_SESSION['userProfile'])
) {
    header("Location: login.php");
    exit();
}

// UserProfile is Valid
if ($_SESSION['userProfile'] != "Cleaner") {
    header("Location: login.php");
    exit();
}

$cleanerID = (int) $_SESSION['id']; // Cleaner ID

// Check if GET['id'] Parameter Exists
if (isset($_GET['id'])) {
    // Get CleanerService
    $controller = new ViewCleanerServiceController();
    $cleanerService = $controller->viewCleanerService($_GET['id'], $cleanerID);
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
  <title>Update Cleaner Service</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-left">
      <img src='img/cleaning-logo.png' alt="Cleaning Logo" width='48px' height='48px'/>
      <a href="viewCleanerService.php" class="active">My Services</a>
      <a href="viewMatches.php">My Matches</a>
    </div>
    <div class="navbar-right">
      <span class="navbar-right-text">Logged in as,<br/>(<?php echo htmlspecialchars($_SESSION["userProfile"]); ?>) <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
      <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>

  <!-- info -->
  <div class="form-container">
    <h2>Update Service</h2>
    <br>
    <form action="controllers/UpdateCleanerServiceController.php" method="post">
      <?php if (isset($_GET['status']) && $_GET['status'] == 0) { ?>
        <div class="alert-danger" role="alert">
          <strong>Update Service Failed: Please Contact Admin</strong>
        </div>
      <?php } else if (isset($_GET['status']) && $_GET['status'] == 1) { ?>
        <div class="alert-success" role="alert">
          <strong>Successfully Updated Service</strong>
        </div>
      <?php } ?>

      <input type="hidden"
             name="cleanerID"
             value="<?php echo htmlspecialchars($cleanerService->getCleanerID()); ?>">

      <div class="form-group">
        <label for="id">ID:</label>
        <input type="text"
               id="id"
               name='id'
               value="<?php echo htmlspecialchars($cleanerService->getId()); ?>" readonly>
      </div>
      <div class="form-group">
        <label for="category">Service Category</label>
        <input type="text"
               id="category"
               name='category'
               value="<?php echo htmlspecialchars($cleanerService->getCategory()); ?>" readonly>
      </div>
      <div class="form-group">
        <label for="serviceName">Service Name</label>
        <input type="text"
               id="serviceName"
               name='serviceName'
               value="<?php echo htmlspecialchars($cleanerService->getServiceName()); ?>">
        <span id='sNameValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
        <label for="price">Price</label>
        <input type="number"
               id="price"
               name='price'
               value="<?php echo htmlspecialchars($cleanerService->getPrice()); ?>">
        <span id='priceValidation' class='text-danger'></span>
      </div>
      <div class="form-group">
          <button type="button"
                  class="suspend-button"
                  onclick="deleteButtonClicked()">Delete</button>
      </div>
      <div class="submit-row">
        <button type="button" onclick='window.location.href="viewCleanerService.php"' class="back-button">Back</button>
        <button type="submit"
                id="submit-button"
                class="submit-button">Update</button>
      </div>
    </form>
  </div>

  <!-- Javascript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    // Delete Button Clicked
    function deleteButtonClicked() {
      if (confirm("Confirm Delete Service?") == true) {
        window.location.href='./controllers/DeleteCleanerServiceController.php?id=<?php echo htmlspecialchars($_GET['id']); ?>&cleanerID=<?php echo htmlspecialchars($cleanerID); ?>'
      }
    }

    // Form Validation
    const form = document.querySelector("form");
    document.getElementById("submit-button").addEventListener("click", function (event) {
      event.preventDefault();

      let isValid = true;

      // Service Name Validation: Not NULL and less than or equal to 48 characters
      const sNameInput = document.getElementById('serviceName');
      const trimmedSName = sNameInput.value.trim();
      if (!trimmedSName) {
          document.getElementById('sNameValidation').innerText = "Service Name cannot be empty.";
          isValid = false;
      } else if (trimmedSName.length > 48) {
          document.getElementById('sNameValidation').innerText = "Service Name cannot exeed more than 48 characters.";
          isValid = false;
      } else {
          document.getElementById('sNameValidation').innerText = "";
      }

      // Price Validation: Not NULL, Positive Value, Less than 10,000, Max. 2 Decimal Points
      const priceInput = document.getElementById('price');
      var trimmedPrice = priceInput.value.trim();
      const priceValue = parseFloat(trimmedPrice);
      if (!trimmedPrice) {
        document.getElementById('priceValidation').innerText = "Price cannot be empty.";
        isValid = false;
      } else if (isNaN(priceValue) || priceValue < 0) {
        document.getElementById('priceValidation').innerText = "Price must be a non-negative number.";
        isValid = false;
      } else if (priceValue >= 10000) {
        document.getElementById('priceValidation').innerText = "Price cannot be 10,000 or more.";
        isValid = false;
      } else {
        if (!/^\d+(\.\d{2})?$/.test(trimmedPrice)) {
          document.getElementById('priceValidation').innerText = "Price must have 2 decimal points.";
          isValid = false;
        } else {
          document.getElementById('priceValidation').innerText = "";
        }
      }

      if (isValid) {
          if (confirm("Confirm Update Service?") == true) {
              form.submit();
          }
      }
    });
  </script>
</body>
</html>