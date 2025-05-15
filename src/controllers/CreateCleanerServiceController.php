<?php

require_once("/var/www/html/entity/CleanerService.php");

class CreateCleanerServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function createCleanerService (
        int $serviceCategoryID,
        int $cleanerID,
        string $serviceName,
        float $price
    ): bool {
        return $this->cleanerService->createCleanerService(
            $serviceCategoryID,
            $cleanerID,
            $serviceName,
            $price
        );
    }
}

/**
 * Script to handle the submission of the Create Service Category form.
 * Expects a POST request with `serviceCategoryID`, 'cleanerID', 'serviceName'
 * and 'price' parameters.
 */
if (
    isset($_POST['serviceCategoryID']) &&
    isset($_POST['cleanerID']) &&
    isset($_POST['serviceName']) &&
    isset($_POST['price'])
    ) {
        // Instantiate New Controller
        $controller = new CreateCleanerServiceController();

        // Convert String Parameters to Integer
        $serviceCategoryID = (int) $_POST['serviceCategoryID'];
        $cleanerID = (int) $_POST['cleanerID'];
        $price = (float) $_POST['price'];

        $status = $controller->createCleanerService(
            $serviceCategoryID,
            $cleanerID,
            $_POST['serviceName'],
            $price
        );

        // Redirect back to the form with status message
        if ($status) {
            header("Location: ../createCleanerService.php?id=$serviceCategoryID&status=1");
            exit();
        } else {
            header("Location: ../createCleanerService.php?id=$serviceCategoryID&status=0");
            exit();
        }
} else {
    $id = (int) $_POST['id'];
    header("Location: ../createCleanerService.php?id=$serviceCategoryID&status=0");
    exit();
}