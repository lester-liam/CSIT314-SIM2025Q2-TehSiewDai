<?php

// Start the session (if not already started)
session_start();

// Include the controller
require_once 'controllers/ViewAllShortlistController.php';
require_once 'controllers/SearchShortlistController.php';

// Ensure User is Logged In
if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
    header("Location: login.php");
    exit();
}

// Ensure User is Cleaner
if ($_SESSION['userProfile'] != "Homeowner") {
     header("Location: login.php");
     exit();
}

$homeownerID = (int) $_SESSION['id']; // Cleaner ID

// Retrieve all Cleaner Services with Controller
$controller = new ViewAllShortlistController();

// Get all user accounts
$shortlist = $controller->viewAllShortlist($homeownerID);

if (isset($_GET['q'])) {

  if ($_GET['q'] != '') {

    $controller = new SearchShortlistController();

    // Remove Quotes & Decode URL (Eg. %20 for Whitespaces)
    $searchTermWithoutQuotes = str_replace(['"', "'"], '', $_GET['q']);
    $searchTerm = urldecode($searchTermWithoutQuotes);

    // Remove 2 or more consecutive whitespaces
    $searchTerm = preg_replace('/\s{2,}/', ' ', $searchTerm);

    // Remove trailing whitespaces
    $searchTerm = ltrim($searchTerm);
    $searchTerm = rtrim($searchTerm);

    $shortlist = $controller->searchShortlist($homeownerID, $searchTerm);

  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Services</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/modal.css">
  <link rel="stylesheet" href="css/columnCard.css">



</head>

<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-left">
      <img src='img/cleaning-logo.png' alt="Cleaning Logo" width='48px' height='48px'/>
      <a href="homeownerHome.php">Home</a>
      <a href="viewShortlist.php" class="active">Shortlist</a>
      <a href="viewBookings.php">History</a>
    </div>
    <div class="navbar-right">
      <span class="navbar-right-text">Logged in as,<br/>(<?php echo htmlspecialchars($_SESSION["userProfile"]); ?>) <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
      <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>

  <!-- Headline -->
  <h1>Service Offerings</h1>

  <div class="section-container">
    <div class="search">
      <div class="search-group">
        <div class="input-wrapper">
          <ion-icon name="search-outline"></ion-icon>
          <input type="text" id="search_term" type="text" placeholder="Search..." value=<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>>
        </div>
        <button onclick='searchBtnClicked()' class="search-button">Search</button>
      </div>
    </div>

    <?php

      $counter = 0; // Initialize Counter to 0
      foreach ($shortlist as $cs) {
          if ($counter % 4 === 0) {
              echo '<div class="row">';
          }

          echo '<div class="column">';
          echo '  <div class="card">';
          echo '    <h3>' . htmlspecialchars(($cs->getServiceName())) . '</h3>';
          echo '    <strong>' . htmlspecialchars(($cs->getCategory())) . '</strong>';
          echo '    <p>' . htmlspecialchars(($cs->getCleanerName())) . '</p>';
          echo '    <button onclick="viewService(' .
                                        htmlspecialchars($cs->getHomeownerID()) . ', ' .
                                        htmlspecialchars($cs->getServiceID()) . ');"' .
                                        ' class="submit-button">View</button>';
          echo '  </div>';
          echo '</div>';

          $counter = $counter + 1;

          if ($counter % 4 === 0) {
              echo '</div>';
          }
      }

      // Close the last row if the number of items is not a multiple of 4
      if ($counter % 4 !== 0) {
          echo '</div>';
      }

      ?>
    </div>

    <!-- The Modal -->
    <div id="ViewServiceModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <h2>Service Info</h2>
          <button class="close">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="category">Service Category</label>
            <input type="text" id="category" disabled>
          </div>
          <div class="form-group">
            <label for="serviceName">Service Name</label>
            <input type="text" id="serviceName" disabled>
          </div>
          <div class="form-group">
            <label for="cleanerName">Cleaner Name</label>
            <input type="text" id="cleanerName" disabled>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" disabled>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <script>

    function searchBtnClicked() {
      var searchTermInput = document.getElementById("search_term");
      var searchTerm = searchTermInput.value;

      // Alphanumeric & Single Whitespace Regex
      searchTerm = searchTerm.replace(/[^a-zA-Z0-9\s]+/g, '');
      searchTerm = searchTerm.replace(/\s+/g, ' ');

      window.location.href = 'viewShortlist.php?q="' + searchTerm + '"';
    }

    const modal = document.getElementById("ViewServiceModal");
    const closeBtn = document.getElementsByClassName("close")[0];

    // Close Modal onClick
    closeBtn.onclick = function() {
      modal.style.display = "none";
    }

    function viewService(homeownerID, serviceID) {

      // Modal
      const CleanerServiceModal = document.getElementById("ViewServiceModal");
      console.log(`./controllers/ViewShortlistController.php?homeownerID=${homeownerID}&serviceID=${serviceID}`);
      // Use fetch API (modern approach) or XMLHttpRequest (older approach)
      fetch(`./controllers/ViewShortlistController.php?homeownerID=${homeownerID}&serviceID=${serviceID}`) // Replace with your PHP script URL
        .then(response => response.json())
        .then(data => {

              // Populate the modal with the data received from PHP
              document.getElementById('category').value = data.category;
              document.getElementById('serviceName').value = data.serviceName;
              document.getElementById('cleanerName').value = data.cleanerName;
              document.getElementById('price').value = data.price;

        CleanerServiceModal.style.display = "block";
      })
      .catch(error => {
        console.error("Error fetching service data:", error);
        alert(error.message)
      });

    }

  </script>

</body>
</html>