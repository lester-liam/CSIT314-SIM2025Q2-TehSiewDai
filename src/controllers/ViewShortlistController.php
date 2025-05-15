<?php

require_once("/var/www/html/entity/Shortlist.php");

class ViewShortlistController
{
    private $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function viewShortlist(int $homeownerID, int $serviceID): ?Shortlist
    {
        return $this->shortlist->viewShortlist($homeownerID, $serviceID);
    }
}

/**
 * Script to handle the request of View Shortlist.
 * Expects a GET request with 'id' and 'serviceID'
 */
if (isset($_GET['homeownerID']) && isset ($_GET['serviceID'])) {
    // Convert String IDs to Integer
    $homeownerID = (int) $_GET['homeownerID'];
    $serviceID = (int) $_GET['serviceID'];

    // Instantiate Controller
    $viewController = new ViewShortlistController();
    $shortlist = $viewController->viewShortlist($homeownerID, $serviceID);

    // Error Getting Service
    if (is_null($shortlist)) {
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    // Parse & Send Response as JSON
    $response = [
        'category' => $shortlist->getCategory(),
        'serviceName' => $shortlist->getServiceName(),
        'cleanerName' => $shortlist->getCleanerName(),
        'price' => $shortlist->getPrice(),
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}