<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Service Category</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<h2>Create New Service Category</h2>

<form action="controllers/CreateServiceCategoryController.php" method="post">
    <label for="serviceName">Service Name:</label>
    <input type="text" id="serviceName" name="serviceName" required><br><br>

    <label for="serviceCategory">Service Category:</label>
    <input type="text" id="serviceCategory" name="serviceCategory" required><br><br>

    <button type="submit">Create</button>
</form>

<button onclick="window.location.href='platformManagementView.php'">Back</button>

</body>
</html>
