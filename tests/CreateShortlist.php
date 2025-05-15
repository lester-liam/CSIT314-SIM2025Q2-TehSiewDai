<?php

require_once "/var/www/html/entity/Shortlist.php";

$scriptRanSuccess = true;
$shortlist = new Shortlist();


function randomShortlists(): array {
    $shortlistedIDs = array();

    $i = 0;
    while ($i < 3) {
        $sID = rand(1, 110);
        if (!in_array($sID, $shortlistedIDs)) {
            $shortlistedIDs[] = $sID;
            $i++;
        }
    }
    return $shortlistedIDs;
}


for ($x = 70; $x <= 108; $x++) {
    $data = randomShortlists();
    foreach ($data as $s) {
        $status = $shortlist->newShortlist(
            $x,
            $s,
        );

        if ($status) {
            echo "Inserted Shortlist Successfully\n";
        } else {
            $scriptRanSuccess = false;
            echo "Inserted Shortlist Unsuccessful\n";
            error_log("Error inserting shortlist");
            continue;
        }
    }
}

// Script Ran Success Message
if ($scriptRanSuccess) {
    echo "\nScript ran successfully.\n";
} else {
    echo "\nScript ran successfully, but with errors, check console or logs.\n";
}
exit();