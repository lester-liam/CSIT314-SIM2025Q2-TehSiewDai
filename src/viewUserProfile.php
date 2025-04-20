<?php

// Start the session (if not already started)
session_start();

// Include the controller
require_once 'controllers/ViewUserProfileController.php';
require_once 'controllers/SearchUserProfileController.php';

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
$controller = new ViewUserProfileController();

// Get all user accounts
$userProfiles = $controller->readAllUserProfile();

if (isset($_GET['q'])) {

  if ($_GET['q'] != '') {

    // Remove quotes (both single and double)
    $searchTermWithoutQuotes = str_replace(['"', "'"], '', $_GET['q']);

    // Decode URL-encoded characters, including %20 for spaces
    $searchTerm = urldecode($searchTermWithoutQuotes);

    // Instantiate the search controller
    $controller = new searchUserProfileController();

    // Search user accounts
    $userProfiles = $controller->searchUserProfile($searchTerm);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Profile</title>
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

    .navbar #selected {
      color: #ECCCBE;
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

    h1 {
      margin-left: 105px;
      margin-top: 30px;
      color: rgb(22, 66, 60);
    }

    .section-container {
      padding: 0 105px;
      margin-top: 20px;
    }

    .search {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .search-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .search input {
      padding: 8px 12px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 300px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper ion-icon {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: rgb(22, 66, 60);
    }

    .input-wrapper input {
      padding: 8px 12px 8px 35px;
      font-size: 16px;
      border: 1px solid white;
      border-radius: 4px;
      background-color: #FFFFFF;
      color: rgb(22, 66, 60);
      width: 300px;
    }

    .create-button {
      display: flex; 
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }

    .search-button,
    .create-button {
      font-size: 16px;
      padding: 7px 20px;
      color: white;
      background-color: rgb(22, 66, 60);
      border: none;
      border-radius: 5px;
      align-items: center;
      cursor: pointer;
    }

    .search-button:hover,
    .create-button:hover {
      background-color: rgb(106, 156, 137);
      transition: 0.2s ease;
    }

    .user-table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 5px;
      overflow: hidden;
      background-color: rgb(255, 255, 255);
    }

    .user-table td:last-child {
      text-align: right;
    }


    .user-table thead {
      background-color: rgb(196, 218, 210);
      font-weight: bold;
      color: rgb(22, 66, 60);
    }

    .user-table th,
    .user-table td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 0.5px solid rgb(196, 218, 210);
    }

    .suspended-yes {
      color: rgb(146, 49, 49);
      font-weight: bold;
    }

    .suspended-no {
      color: rgb(22, 66, 60);
      font-weight: bold;
    }

    .view-button {
      background-color: rgb(22, 66, 60);
      color: white;
      border: none;
      border-radius: 5px;
      padding: 6px 16px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.2s ease;
      text-decoration:none;
    }

    .view-button:hover {
      background-color: rgb(106, 156, 137);
    }

  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <ul>
      <li><a href="viewUserProfile.php" id="selected">User Profile</a></li>
      <li><a href="viewUserAccount.php">User Account</a></li>
    </ul>
    <div class="logout-button">
      <button onclick="window.location.href='logout.php'">Log out</button>
    </div>
  </nav>

  <!-- Headline -->
  <h1>User Profile</h1>

  <div class="section-container">
    <div class="search">
      <div class="search-group">
        <div class="input-wrapper">
          <ion-icon name="search-outline"></ion-icon>
          <input id="search_term" type="text" placeholder="Search..." value=<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>>
        </div>
        <button onclick='window.location.href="viewUserProfile.php?q=\"" + document.getElementById("search_term").value + "\"";' class="search-button">Search</button>
      </div>
      <button onclick='window.location.href="createUserProfile.php"' class="create-button">
        <ion-icon name="add-outline"></ion-icon>
        Create
      </button>
    </div>

    <!-- User Table -->
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>User Type</th>
          <th>Description</th>
          <th>Suspended</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($userProfiles as $up): ?>
          <tr>
              <td><?php echo htmlspecialchars($up['id']); ?></td>
              <td><?php echo htmlspecialchars($up['role']); ?></td>
              <td><?php echo htmlspecialchars($up['description']); ?></td>
              <td class="<?php if ($up['isSuspend'] == 1) { echo 'suspended-yes'; } else { echo 'suspended-no'; } ?>">
                <?php if ($up['isSuspend'] == 1) { echo 'YES'; } else { echo 'NO'; } ?>
              </td>
              <td>
                <button onclick='window.location.href="updateUserProfile.php?id=<?php echo htmlspecialchars($up['id']); ?>"' class="view-button">View</button>
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