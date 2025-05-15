<?php

require_once("/var/www/html/entity/Shortlist.php");

class NewShortlistController
{
    private $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function newShortlist(int $homeownerID, int $serviceID): bool
    {
        return $this->shortlist->newShortlist($homeownerID, $serviceID);
    }
}

/**
 * Script to handle the request of the Shortlisting Service
 * Expects a GET request with 'homeownerID' and 'serviceID'
 */
if (isset($_GET['homeownerID']) && isset($_GET['serviceID'])) {
    // Convert String IDs to Integer
    $homeownerID = (int) $_GET['homeownerID'];
    $serviceID = (int) $_GET['serviceID'];

    // Instantiate New Controller
    $controller = new NewShortlistController();
    $status = $controller->newShortlist($homeownerID, $serviceID);

    // Parse Success/Fail Response
    if ($status) {
        $response = [
            'isSuccess' => true,
        ];
    } else {
        $response = [
            'isSuccess' => false,
        ];
    }

    // Send Response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}