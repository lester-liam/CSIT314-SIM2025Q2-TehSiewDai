<?php

require_once "/var/www/html/entity/ServiceCategory.php";

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
$serviceCategory = new ServiceCategory();
// Loop Through Each Word & Create New Service Category
foreach ($uniqueStrings as $w) {
    $status = $serviceCategory->createServiceCategory($w, "Lorem ipsum dolor sit amet");

    if ($status) {
        echo "Inserted Service Category Successfully\n";
    } else {
        $scriptRanSuccess = false;
        echo "Inserted Service Category Unsuccessful\n";
        error_log("Error inserting service category " . $w);
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