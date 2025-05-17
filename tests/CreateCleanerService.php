<?php

require_once "/var/www/html/entity/CleanerService.php";

// Lorem Ipsum Paragraph
$text = "Lorem ipsum dolor sit amet consectetur adipiscing elit quisque faucibus ex sapien vitae pellentesque sem
         placerat in id cursus mi pretium tellus duis convallis tempus leo eu aenean sed diam urna tempor pulvinar
         vivamus fringilla lacus nec metus bibendum egestas iaculis massa nisl malesuada lacinia integer nunc posuere ut
         hendrerit semper vel class aptent taciti sociosqu ad litora torquent per conubia nostra inceptos himenaeos orci
         varius natoque penatibus et magnis dis parturient montes nascetur ridiculus mus donec rhoncus eros lobortis
         nullamolestie mattis scelerisque maximus eget fermentum odio phasellus non purus est efficitur laoreet mauris
         pharetra vestibulum fusce dictum risus";

// Split String into Array of Words
$words = str_word_count($text, 1);

$uniqueStrings = []; // Array to Store Unique List of Strings
// Generate Random 2 Word Strings (for Category Name)
while (count($uniqueStrings) < 100) {

    // Pick two random words
    $i1 = array_rand($words);
    $i2 = array_rand($words);
    $word1 = $words[$i1];
    $word2 = $words[$i2];

    // Apply title casing and create the string
    $uniqueString = ucwords($word1) . ' ' . ucwords($word2);

    // Append to array if not exists inside
    if (!in_array($uniqueString, $uniqueStrings)) {
        $uniqueStrings[] = $uniqueString;
    }
}

$scriptRanSuccess = true;
$cleanerService = new CleanerService();
// Loop Through Each Word & Create New Cleaner Service
foreach ($uniqueStrings as $w) {

    // Randomly Create for Demo Users
    $y = rand(0, 1);
    if ($y == 1) {
        $cID = rand(3, 5);
    } else {
        $cID = rand(40, 69);
    }

    $status = $cleanerService->createCleanerService(
        rand(1, 107),
        $cID,
        $w,
        rand(100, 500)
    );

    if ($status) {
        echo "Inserted CleanerService Successfully\n";
    } else {
        $scriptRanSuccess = false;
        echo "Inserted CleanerService Unsuccessful\n";
        error_log("Error inserting cleaner service " . $w);
        continue;
    }
}

// Script Ran Success Message
if ($scriptRanSuccess) {
    echo "\nScript ran successfully.\n";
} else {
    echo "\nScript ran successfully, but with errors, check console or logs.\n";
}
exit();