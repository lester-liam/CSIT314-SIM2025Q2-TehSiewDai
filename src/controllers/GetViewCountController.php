<?php

require_once("/var/www/html/entity/CleanerService.php");

class GetViewCountController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function getViewCount(int $id): int
    {
        return $this->cleanerService->getViewCount($id);
    }
}

/**
 * Script to handle the request of View Service.
 * Expects a GET request with 'id'
 */
if (isset($_GET['id'])) {

    // Convert String ID to Integer
    $id = (int) $_GET['id'];

    // Instantiate Controller
    $controller = new GetViewCountController();
    $numViews = $controller->getViewCount($id);

    // Parse & Send Response as JSON
    $response = [
        'numViews' => $numViews
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}