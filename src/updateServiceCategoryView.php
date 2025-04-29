<?php
session_start();
// 这里也可以加校验
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Service Category</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Update Service Category</h2>

<form action="controllers/UpdateServiceCategoryController.php" method="post">
    <label for="id">Service Category ID:</label>
    <input type="text" id="id" name="id" required><br><br>

    <label for="serviceName">New Service Name:</label>
    <input type="text" id="serviceName" name="serviceName" required><br><br>

    <label for="serviceCategory">New Service Category:</label>
    <input type="text" id="serviceCategory" name="serviceCategory" required><br><br>

    <button type="submit">Update</button>
</form>

<button onclick="window.location.href='platformManagementView.php'">Back</button>

</body>
</html>
