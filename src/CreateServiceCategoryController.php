<?php
require_once '../entity/ServiceCategory.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceName = $_POST['serviceName'] ?? '';
    $serviceCategory = $_POST['serviceCategory'] ?? '';

    if (!empty($serviceName) && !empty($serviceCategory)) {
        $sc = new ServiceCategory();
        $result = $sc->createServiceCategory($serviceName, $serviceCategory);

        if ($result) {
            echo "New Service Category created successfully.";
            // header("Location: platformManagement.php");
        } else {
            echo "Failed to create Service Category.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>
