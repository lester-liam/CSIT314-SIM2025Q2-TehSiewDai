<?php 
    // Check if the user is logged in
    // Display the login page if not logged in
    if (!isset($_SESSION['id']) && !isset($_SESSION['username']) && !isset($_SESSION['userProfile'])) {
?>
    <!DOCTYPE html>
    <html>
        <head>
        <meta charset="utf-8">
            <title>Cleaner Management System</title>

            <!-- Bootstrap core CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

            <!-- Custom CSS Template -->
            <link href="./css/login.css" rel="stylesheet">
        </head>
        
        <body class="text-center">
            <div class="form-signin shadow">
                    <form action="controllers/LoginController.php" method="post">
                        <h1 class="h3 mb-3 fw-normal">Login</h1>
                        <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$_GET['error']?>
                        </div>
                        <?php } ?>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="user123" required>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select" id="floatingUserProfile" name="userProfile">
                                <option value="Homeowner" selected>Homeowner</option>
                                <option value="Cleaner">Cleaner</option>
                                <option value="Platform Management">Platform Management</option>
                                <option value="User Admin">User Admin</option>
                            </select>
                            <label for="floatingUserProfile">User Profile</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                    </form>
            </div>
    </body>
    </html>
<?php 
}