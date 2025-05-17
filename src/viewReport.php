<?php

session_start();

require_once 'controllers/ViewDailyReportController.php';
require_once 'controllers/ViewWeeklyReportController.php';
require_once 'controllers/ViewMonthlyReportController.php';

// Check if User is Logged In
if (
    !isset($_SESSION['id']) &&
    !isset($_SESSION['username']) &&
    !isset($_SESSION['userProfile'])
) {
    header("Location: login.php");
    exit();
}

// Check if UserProfile is Valid
if ($_SESSION['userProfile'] != "Platform Management") {
    header("Location: login.php");
    exit();
}

// View Report if GET['reportDate'] Parameter Exists
if (isset($_GET['reportDate'])) {
    if ($_GET['reportDate'] == 'D') {
        $controller = new ViewDailyReportController();
        $report = $controller->getDailyReport();
    } else if ($_GET['reportDate'] == 'W') {
        $controller = new ViewWeeklyReportController();
        $report = $controller->getWeekyReport();
    } else if ($_GET['reportDate'] == 'M') {
        $controller = new ViewMonthlyReportController();
        $report = $controller->getMonthlyReport();
    } else {
        $controller = new ViewDailyReportController();
        $report = $controller->getDailyReport();
    }
} else {
    // Default to Daily Report
    $controller = new ViewDailyReportController();
    $report = $controller->getDailyReport();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Report</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dropdown.css">
</head>

<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-left">
      <img src='img/cleaning-logo.png' alt="Cleaning Logo" width='48px' height='48px'/>
      <a href="viewServiceCategory.php">Services</a>
      <a href="viewReport.php" class="active">Report</a>
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
  <h1>Report</h1>
  <div class="section-container">
    <div class="search">
      <div class="search-group">
        <div class="input-wrapper">
          <div class="dropdown">
            <button class="dropbtn">Reporting Period</button>
            <div class="dropdown-content">
              <a href="viewReport.php?reportDate=D">Daily</a>
              <a href="viewReport.php?reportDate=W">Weekly</a>
              <a href="viewReport.php?reportDate=M">Monthly</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Display Table -->
    <table class="display-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Category</th>
          <th>No. of New Services</th>
          <th>No. of Updated Services</th>
          <th>Total Views</th>
          <th>Total Shortlists</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($report as $r): ?>
        <tr>
            <td><?php echo htmlspecialchars($r->getDate()); ?></td>
            <td><?php echo htmlspecialchars($r->getCategory()); ?></td>
            <td><?php echo htmlspecialchars($r->getNumNewService()); ?></td>
            <td><?php echo htmlspecialchars($r->getNumUpdatedService()); ?></td>
            <td>
                <?php echo htmlspecialchars($r->getTotalViews()); ?>
            </td>
            <td style="display:table-cell; text-align:left;">
                <p><?php echo htmlspecialchars($r->getTotalShortlists()); ?></p>
            </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- JavaScript -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>