<?php

require_once("/var/www/html/entity/CleanerService.php");

class ViewCleanerServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function viewCleanerService(int $id, int $cleanerID): ?CleanerService
    {
        return $this->cleanerService->viewCleanerService($id, $cleanerID);
    }
}

/**
 * Script to handle the request of View Service.
 * Expects a GET request with 'id' and 'cleanerID'
 */
if (isset($_GET['id']) && isset($_GET['cleanerID'])) {
    // Convert String IDs to Integer
    $id = (int) $_GET['id'];
    $cleanerID = (int) $_GET['cleanerID'];

    // Instantiate Controller
    $viewController = new ViewCleanerServiceController();
    $service = $viewController->viewCleanerService($id, $cleanerID);

    // Error Getting Service
    if (is_null($service)) {
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    // Parse & Send Response as JSON
    $response = [
        'id' => $service->getId(),
        'category' => $service->getCategory(),
        'serviceName' => $service->getServiceName(),
        'price' => $service->getPrice(),
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}