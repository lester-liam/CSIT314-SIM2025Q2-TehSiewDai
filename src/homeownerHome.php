<?php

session_start();

require_once 'controllers/ViewAllShortlistController.php';
require_once 'controllers/HoViewAllServiceController.php';
require_once 'controllers/HoSearchServiceController.php';

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
if ($_SESSION['userProfile'] != "Homeowner") {
    header("Location: login.php");
    exit();
}

$homeownerID = (int) $_SESSION['id']; // Homeowner ID

// Retrieve the Homeowner's Current Shortlist
$shortlistController = new ViewAllShortlistController();
$shortlistedServices = $shortlistController->viewAllShortlist($homeownerID);

// Extract Service IDs from the Shortlist Array
$shortlistedServiceIDs = [];
if ($shortlistedServices) {
    foreach ($shortlistedServices as $s) {
        $shortlistedServiceIDs[] = $s->getServiceID();
    }
}

// Search Service if GET['q'] Parameter Exists
if (isset($_GET['q'])) {
  if ($_GET['q'] != '') {
    // Remove Quotes, URL Decode, Trim Consecutive/Trailing Whitespaces
    $searchTerm = str_replace(['"', "'"], '', $_GET['q']);

    // URL Decode
    $searchTerm = urldecode($searchTerm);

    // Trim Consecutive/Trailing Whitespaces
    $searchTerm = preg_replace('/\s{2,}/', ' ', $searchTerm);
    $searchTerm = ltrim($searchTerm);
    $searchTerm = rtrim($searchTerm);

    // Search Cleaner Service
    $controller = new HoSearchServiceController();
    $cleanerService = $controller->hoSearchService($searchTerm);
  }
} else {
    // Read All Services
    $controller = new HoViewAllServiceController();
    $cleanerService = $controller->hoViewAllService();
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
      <a href="homeownerHome.php" class="active">Home</a>
      <a href="viewShortlist.php">Shortlist</a>
      <a href="viewBookings.php">History</a>
    </div>
    <div class="navbar-right">
      <span class="navbar-right-text">Logged in as,<br/>
        (<?php echo htmlspecialchars($_SESSION["userProfile"]); ?>)
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
      </span>
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
          <input type="text" id="search_term" type="text" placeholder="Search..."
                 value=<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>>
        </div>
        <button onclick='searchBtnClicked()' class="search-button">Search</button>
      </div>
    </div>
    <?php

      $counter = 0; // Initialize Counter to 0
      foreach ($cleanerService as $cs) {
          $isShortlisted = in_array($cs->getId(), $shortlistedServiceIDs);

          // Create a Row of Column Cards
          if ($counter % 4 === 0) {
              echo '<div class="row">';
          }
          // Create Column & Card
          echo '<div class="column">';
          echo '  <div class="card">';
          echo '    <h3>' . htmlspecialchars(($cs->getServiceName())) . '</h3>';
          echo '    <strong>' . htmlspecialchars(($cs->getCategory())) . '</strong>';
          echo '    <p>' . htmlspecialchars(($cs->getCleanerName())) . '</p>';
          echo '    <button onclick="viewService(' .
                                        $cs->getId() . ')"' .
                                        ' class="submit-button">View</button>';
          // If isShortlisted (Disable Button)
          if ($isShortlisted) {
            echo '    <button onclick="shortlistService(' .
            $cs->getId() . ', ' .
            $homeownerID . ')"' .
            ' class="submit-button-disabled" disabled>Shortlist</button>';
          } else {
            echo '    <button onclick="shortlistService(' .
            $cs->getId() . ', ' .
            $homeownerID . ')"' .
            ' class="submit-button">Shortlist</button>';
          }

          echo '  </div>';
          echo '</div>'; // Close Column & Card

          $counter = $counter + 1; // Increment Counter
          if ($counter % 4 === 0) {
              echo '</div>'; // Close Outer Row Div
          }
      }

      // Close Last Row (When n items is not a multiple of 4)
      if ($counter % 4 !== 0) {
          echo '</div>';
      }
      ?>
    </div>

    <!-- The Modal -->
    <div id="ViewServiceModal" class="modal">
      <!-- Modal Content -->
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

  <!-- Javascript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <script>
    // Search Button Clicked
    function searchBtnClicked() {
      // Get Search Input
      var searchTermInput = document.getElementById("search_term");
      var searchTerm = searchTermInput.value;

      // Alphanumeric & Single Whitespace Regex
      searchTerm = searchTerm.replace(/[^a-zA-Z0-9\s]+/g, '');
      searchTerm = searchTerm.replace(/\s+/g, ' ');

      // Update URL to include GET['q'] Parameter
      window.location.href = 'homeownerHome.php?q="' + searchTerm + '"';
    }

    const modal = document.getElementById("ViewServiceModal");
    const closeBtn = document.getElementsByClassName("close")[0];

    // Close Modal onClick
    closeBtn.onclick = function() {
      modal.style.display = "none";
    }

    // Display Modal
    function viewService(id) {
      // Modal Element
      const CleanerServiceModal = document.getElementById("ViewServiceModal");

      // Fetch Service Info
      fetch(`./controllers/HoViewServiceController.php?id=${id}`) // Replace with your PHP script URL
            .then(response => response.json()) // Or response.text() if you're not expecting JSON
            .then(data => {
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

    // Shortlist Service
    function shortlistService(serviceID, homeownerID) {
      // Confirm Prompt & Call Controller
      if (confirm("Confirm Shortlist?") == true) {
        fetch(`./controllers/NewShortlistController.php?homeownerID=${homeownerID}&serviceID=${serviceID}`) // Replace with your PHP script URL
              .then(response => response.json()) // Or response.text() if you're not expecting JSON
              .then(data => {
                if (data.isSuccess) {
                  alert ("Shortlisted Successful");
                  window.location.reload(true);
                } else {
                  alert ("This Service is Already Shortlisted");
                }
        })
        .catch(error => {
          console.error("Error fetching service data:", error);
          alert("Error Shortlisting Service, please contact an Admin");
        });
      }
    }
  </script>
</body>
</html>