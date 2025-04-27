<?php
require_once '../entity/ServiceCategory.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $serviceName = $_POST['serviceName'] ?? '';
    $serviceCategory = $_POST['serviceCategory'] ?? '';

    if (!empty($id) && !empty($serviceName) && !empty($serviceCategory)) {
        $sc = new ServiceCategory();
        $result = $sc->updateServiceCategory($id, $serviceName, $serviceCategory);

        if ($result) {
            echo "Service Category updated successfully.";
            // header("Location: platformManagement.php");
        } else {
            echo "Update failed.";
        }
    } else {
        echo "All fields are required.";
    }
}
?>
