<?php

// Start the session (if not already started)
session_start();

// Include the controller
require_once 'controllers/ViewAllUserAccountController.php';
require_once 'controllers/SearchUserAccountController.php';

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

// Retrieve all user profiles with Controller
$controller = new ViewAllUserAccountController();

// Get all user accounts
$userAccounts = $controller->readAllUserAccount();

if (isset($_GET['q'])) {

  if ($_GET['q'] != '') {

    // Remove quotes (both single and double)
    $searchTermWithoutQuotes = str_replace(['"', "'"], '', $_GET['q']);

    // Decode URL-encoded characters, including %20 for spaces
    $searchTerm = urldecode($searchTermWithoutQuotes);

    // Instantiate the search controller
    $controller = new SearchUserAccountController();

    // Search user accounts
    $userAccounts = $controller->searchUserAccount($searchTerm);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Profile</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <ul>
      <li><a href="viewUserProfile.php">User Profile</a></li>
      <li><a href="viewUserAccount.php" id="selected">User Account</a></li>
    </ul>
    <div class="logout-button">
      <button class="logout-button" onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <!-- Headline -->
  <h1>User Account</h1>

  <div class="section-container">
    <div class="search">
      <div class="search-group">
        <div class="input-wrapper">
          <ion-icon name="search-outline"></ion-icon>
          <input id="search_term" type="text" placeholder="Search..." value=<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>>
        </div>
        <button onclick='window.location.href="viewUserAccount.php?q=\"" + document.getElementById("search_term").value + "\"";' class="search-button">Search</button>
      </div>
      <button onclick='window.location.href="createUserAccount.php"' class="create-button">
        <ion-icon name="add-outline"></ion-icon>
        Create
      </button>
    </div>

    <!-- User Table -->
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Suspended</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($userAccounts as $ua): ?>
          <tr>
              <td><?php echo htmlspecialchars($ua['id']); ?></td>
              <td><?php echo htmlspecialchars($ua['username']); ?></td>
              <td><?php echo htmlspecialchars($ua['email']); ?></td>
              <td><?php echo htmlspecialchars($ua['phone']); ?></td>
              <td class="<?php if ($ua['isSuspend'] == 1) { echo 'suspended-yes'; } else { echo 'suspended-no'; } ?>">
                <?php if ($ua['isSuspend'] == 1) { echo 'YES'; } else { echo 'NO'; } ?>
              </td>
              <td>
                <button onclick='window.location.href="updateUserAccount.php?id=<?php echo htmlspecialchars($ua["id"]); ?>"' class="view-button">View</button>
              </td>
          </tr>
      <?php endforeach; ?>
  </tbody>
</table>
  </div>


  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>