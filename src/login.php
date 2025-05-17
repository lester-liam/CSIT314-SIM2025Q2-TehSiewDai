<?php
    // Start Session & Check if Session Variables been Initialized
    session_start();
    if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cleaner Management System</title>
    <link href="./css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="form-container">
      <img src='img/cleaning-logo.png' alt="Cleaning Logo" width='96px' height='96px'/>
      <h2>Login</h2>
      <br/>
      <form action="controllers/LoginController.php" method="post">
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert-danger" role="alert">
                <strong><?=$_GET['error']?></strong>
            </div>
        <?php } ?>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <label for="userProfile">User Profile</label>
          <select id="userProfile" name="userProfile">
            <option value="Homeowner" selected>Homeowner</option>
            <option value="Cleaner">Cleaner</option>
            <option value="Platform Management">Platform Management</option>
            <option value="User Admin">User Admin</option>
          </select>
        </div>
        <div class="submit-row">
          <button class="submit-button" type="submit">Sign in</button>
        </div>
      </form>
    </div>
  </body>
</html>
<?php } ?>