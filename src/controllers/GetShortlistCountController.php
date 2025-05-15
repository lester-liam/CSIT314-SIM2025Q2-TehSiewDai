<?php

require_once("/var/www/html/entity/CleanerService.php");

class GetShortlistCountController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    public function getShortlistCount(int $id): int
    {
        return $this->cleanerService->getShortlistCount($id);
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
    $controller = new GetShortlistCountController();
    $numShortlists = $controller->getShortlistCount($id);

    // Parse & Send Response as JSON
    $response = [
        'numShortlists' => $numShortlists
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}