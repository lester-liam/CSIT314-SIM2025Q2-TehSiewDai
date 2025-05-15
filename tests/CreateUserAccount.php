<?php

require_once "/var/www/html/entity/UserAccount.php";

// Read JSON File Content, if fail exit script
$json_file = "/var/www/html/tests/Users_DummyJSON.json";
$file_contents = file_get_contents($json_file);
if ($file_contents === false) {
    unset($db_conn);
    die('Error: Could not read JSON file.');
}

// Decode JSON Data, if fail exit script
$data = json_decode($file_contents, true);
if ($data === null) {
    unset($db_conn);
    die('Error: JSON File cannot be decoded.');
}

$insertCount = 0; // Number of Inserts Counter
$scriptRanSuccess = true;
$userAccount = new UserAccount();

// Loop Through Each User & Insert New Record
foreach ($data['users'] as $user) {
    // Merge First and Last Name
    $fullName = $user['firstName'] . " " . $user['lastName'];
    $password = $user['password'];
    $phone = strval(rand(80000000, 99999999)); // Random Phone Number

    // Insert Role Based on Count:
    //  <= 10           : User Admins
    //  >10 and <= 30   : Platform Management
    //  >30 and <= 60   : Cleaner
    //  >60             : Homeowner
    if ($insertCount <= 10) {
        $up = "User Admin";
    } elseif ($insertCount > 10 && $insertCount <= 30) {
        $up = "Platform Management";
    } elseif ($insertCount > 30 && $insertCount <= 60) {
        $up = "Cleaner";
    } else {
        $up = "Homeowner";
    }

    // Insert User Account & Check if Successful
    $status = $userAccount->createUserAccount(
        $user['username'],
        $password,
        $fullName,
        $user['email'],
        $phone,
        $up
    );
    if ($status) {
        echo "Inserted user successfully\n";
    } else {
        $scriptRanSuccess = false;
        echo "Inserted user unsuccessful\n";
        error_log("Error inserting user " . $user['username']);
        continue;
    }

    $insertCount = $insertCount + 1; // Increment Counter
}

// Script Ran Success Message
if ($scriptRanSuccess) {
    echo "\nScript ran successfully.\n";
} else {
    echo "\nScript ran successfully, but with errors, check console or logs.\n";
}
exit();