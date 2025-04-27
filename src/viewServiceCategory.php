<?php

// Start the session (if not already started)
session_start();

// Include the controller
require_once 'controllers/ViewAllServiceCategoryController.php';
require_once 'controllers/SearchServiceCategoryController.php';

// Ensure User is Logged In
if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
    header("Location: login.php");
    exit();
}

// Ensure User is Platform Management
if ($_SESSION['userProfile'] != "Platform Management") {
     header("Location: login.php");
     exit();
}

// Retrieve all Service Category with Controller
$controller = new ViewAllServiceCategoryController();

// Get all Service Category
$serviceCategories = $controller->readAllServiceCategory();

if (isset($_GET['q'])) {

  if ($_GET['q'] != '') {

    // Remove quotes (both single and double)
    $searchTermWithoutQuotes = str_replace(['"', "'"], '', $_GET['q']);

    // Decode URL-encoded characters, including %20 for spaces
    $searchTerm = urldecode($searchTermWithoutQuotes);

    // Instantiate the search controller
    $controller = new SearchServiceCategoryController();

    // Search user accounts
    $serviceCategories = $controller->searchServiceCategory($searchTerm);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Service Category</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <ul>
      <li><a href="viewServiceCategory.php" id="selected">Service Category</a></li>
      <li><a href="#">Report</a></li>
    </ul>
    <div class="logout-button">
      <button onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <!-- Headline -->
  <h1>Service Category</h1>

  <div class="section-container">
    <div class="search">
      <div class="search-group">
        <div class="input-wrapper">
          <ion-icon name="search-outline"></ion-icon>
          <input type="text" id="search_term" type="text" placeholder="Search..." value=<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>>
        </div>
        <button onclick='window.location.href="viewServiceCategory.php?q=\"" + document.getElementById("search_term").value + "\"";' class="search-button">Search</button>
      </div>
      <button onclick='window.location.href="createServiceCategory.php"' class="create-button">
        <ion-icon name="add-outline"></ion-icon>
        Create
      </button>
    </div>

    <!-- User Table -->
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Service Category</th>
          <th>Service Name</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($serviceCategories as $sc): ?>
          <tr>
              <td><?php echo htmlspecialchars($sc['id']); ?></td>
              <td><?php echo htmlspecialchars($sc['serviceName']); ?></td>
              <td><?php echo htmlspecialchars($sc['serviceCategory']); ?></td>
              <td>
                <button class="view-button" onclick='window.location.href="updateServiceCategory.php?id=<?php echo htmlspecialchars($sc["id"]); ?>"'>View</button>
                <button class="delete-button" onclick="deleteButtonClicked('<?php echo htmlspecialchars($sc['id']); ?>')">Delete</button>
              </td>
              
          </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script>
  function deleteButtonClicked(id) {
    if (confirm("Confirm Delete Service Category?") == true) {
      window.location.href='./controllers/DeleteServiceCategoryController.php?id=' + id;
    }
  }
</script>

</body>
</html>