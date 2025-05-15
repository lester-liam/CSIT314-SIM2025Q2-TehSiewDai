<?php

require_once "/var/www/html/entity/Database.php";

$services = array(
    'General House Cleaning',
    'Deep Cleaning',
    'Move-In/Move-Out Cleaning',
    'Specialized Room Cleaning',
    'Post-Renovation Cleaning',
    'Carpet and Upholstery Cleaning',
    'Window Cleaning Services',
);

function createDate(): string {
    $year = "2025";
    $month = rand(1, 5);

    if ($month == 2) {
        $day = rand(1, 28);
    } elseif ($month == 5) {
        $day = rand(1, 10);
    } else {
        $day = rand(1, 30);
    }

    $hour = rand(8, 18);
    $minute = rand(0, 59);

    $timestamp = $year . "-" . $month . "-" . $day . " " . $hour. ":" . "$minute" . ":00";
    return $timestamp;
}

$scriptRanSuccess = true;
for ($x = 0; $x < 100; $x++) {
    // New DB Connnection
    $db_handle = new Database();
    $db_conn = $db_handle->getConnection();
    try {
        // Get Random Values
        $i = array_rand($services);
        $category = $services[$i];
        $cID = rand(40, 69);
        $hoID = rand(70, 108);
        $sDate = createDate();
        error_log("Date before bindParam: " . $sDate);  // Debugging

        // Prepare SQL Statement
        $sql = "INSERT INTO `ServiceHistory` (category, cleanerID, homeownerID, serviceDate) VALUES
                (:category, :cID, :hoID, :sDate)";
        $stmt = $db_conn->prepare($sql);

        // Bind Parameters and Execute
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':cID', $cID);
        $stmt->bindParam(':hoID', $hoID);
        $stmt->bindParam(':sDate', $sDate);
        $execResult = $stmt->execute();

        // Check Success/Fail
        if ($execResult) {
            echo("Successfully Inserted ServiceHistory");
        } else {
            error_log("Insert ServiceHistory Unsuccessful: " . $sql);
            $scriptRanSuccess = false;
        }
    } catch (PDOException $e) {
        $scriptRanSuccess = false;
        error_log("Insert ServiceHistory Unsuccessful: " . $e->getMessage());
        continue;
    }

    unset($db_handle);
}

// Script Ran Success Message
if ($scriptRanSuccess) {
    echo "\nScript ran successfully.\n";
} else {
    echo "\nScript ran successfully, but with errors, check console or logs.\n";
}
exit();