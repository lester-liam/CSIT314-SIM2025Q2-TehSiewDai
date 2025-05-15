<?php

require_once("/var/www/html/entity/CleanerService.php");

class UpdateCleanerServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function updateCleanerService(
        int $id,
        int $cleanerID,
        string $serviceName,
        float $price
    ): bool {
        return $this->cleanerService->updateCleanerService(
            $id,
            $cleanerID,
            $serviceName,
            $price
        );
    }
}

/**
 * Script to handle the submission of Update Cleaner Service Form
 * Expects a GET request with 'id', 'cleanerID', 'serviceName' and 'price'
 */
if (
    isset($_POST['id']) &&
    isset($_POST['cleanerID']) &&
    isset($_POST['serviceName']) &&
    isset($_POST['price'])
    ) {
        // Convert String ID to integer
        $id = (int) $_POST['id'];
        $cleanerID = (int) $_POST['cleanerID'];
        $price = (float) $_POST['price'];

        // Instantiate New Controller
        $controller = new UpdateCleanerServiceController();
        $status = $controller->updateCleanerService($id, $cleanerID, $_POST['serviceName'], $price);

        // Redirect back to the form with status message
        if ($status) {
            header("Location: ../updateCleanerService.php?id=$id&status=1");
            exit();
        } else {
            header("Location: ../updateCleanerService.php?id=$id&status=0");
            exit();
        }
} else {
    $id = (int) $_POST['id'];
    header("Location: ../updateCleanerService.php?id=$id&status=0");
    exit();
}