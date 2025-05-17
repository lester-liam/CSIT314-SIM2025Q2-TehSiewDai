<?php

require_once "/var/www/html/entity/Database.php";

// List of Demo Service Categories
$services = array(
    'General House Cleaning',
    'Deep Cleaning',
    'Move-In/Move-Out Cleaning',
    'Specialized Room Cleaning',
    'Post-Renovation Cleaning',
    'Carpet and Upholstery Cleaning',
    'Window Cleaning Services',
);

// Create Random Timestamp Date
function createDate(): string {
    $year = "2025";
    $month = rand(1, 5);    // Random Month

    // Ensure February Date <=28 & No Future Dates
    if ($month == 2) {
        $day = rand(1, 28);
    } elseif ($month == 5) {
        $day = rand(1, 10);
    } else {
        $day = rand(1, 30);
    }

    // Random Hour & Minute
    $hour = rand(8, 18);
    $minute = rand(0, 59);

    // Create Timestamp & Return as String
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

        // Randomly Input for Demo Users
        $y = rand(0, 1);
        if ($y == 1) {
            $cID = rand(3, 5);
            $hoID = rand(6, 8);
        } else {
            $cID = rand(40, 69);
            $hoID = rand(70, 108);
        }

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