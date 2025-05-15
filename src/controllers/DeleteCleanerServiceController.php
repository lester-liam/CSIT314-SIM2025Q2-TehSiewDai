<?php

require_once("/var/www/html/entity/CleanerService.php");

class DeleteCleanerServiceController
{
    private $cleanerService;

    public function __construct()
    {
        $this->cleanerService = new CleanerService();
    }

    // Delete Cleaner Service
    public function deleteCleanerService(int $id, int $cleanerID): bool
    {
        return $this->cleanerService->deleteCleanerService($id, $cleanerID);
    }
}

/**
 * Script to handle the submission of the Create UserProfile form.
 * Expects a GET request with 'id' and 'cleanerID'
 */
if (isset($_GET['id']) && isset($_GET['cleanerID'])) {
    // Convert ID to Integer Value
    $id = (int) $_GET['id'];
    $cleanerID = (int) $_GET['cleanerID'];

    // Instantiate New Controller
    $controller = new DeleteCleanerServiceController();
    $status = $controller->deleteCleanerService($id, $cleanerID);

    // Alert Status Message, then Redirect to Page
    if ($status) {
        echo '<script>
                alert ("Delete Successful");
                window.location.href="../viewCleanerService.php";
             </script>';
    } else {
        echo '<script>
                alert ("Delete Failed");
                window.location.href="../viewCleanerService.php";
             </script>';
    }
} else {
    echo '<script>
            alert ("Delete Failed");
            window.location.href="../viewCleanerService.php";
         </script>';
}