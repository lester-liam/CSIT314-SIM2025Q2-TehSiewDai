<?php

require_once("/var/www/html/entity/CleanerService.php");

class HoViewServiceController
{
    private $cleanerService;

    public function __construct() {
        $this->cleanerService = new CleanerService();
    }

    public function hoViewService(int $id): ?CleanerService
    {
        return $this->cleanerService->hoViewService($id);
    }
}

/**
 * Script to handle the request of View Service.
 * Expects a GET request with 'id'
 */
if (isset($_GET['id'])) {
    // Convert String ID to Integer
    $id = (int) $_GET['id'];

    // Instantiate New Controller
    $viewController = new HoViewServiceController();
    $service = $viewController->hoViewService($id);

    // Error Getting Service
    if (is_null($service)) {
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    // Parse & Send Response as JSON
    $response = [
        'category' => $service->getCategory(),
        'serviceName' => $service->getServiceName(),
        'cleanerName' => $service->getCleanerName(),
        'price' => $service->getPrice(),
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}