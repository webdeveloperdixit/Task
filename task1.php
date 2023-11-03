<?php
// Define the folder path
$folderPath = '/datafiles';

// Create a regular expression pattern to match the desired file names
$pattern = '/^[A-Za-z0-9]+\.ixt$/';

// Initialize an array to store matching file names
$matchingFiles = [];

// Check if the folder exists
if (is_dir($folderPath)) {
    // Open the folder
    $directory = opendir($folderPath);

    // Loop through the files in the folder
    while (false !== ($file = readdir($directory))) {
        // Check if the file matches the pattern
        if (preg_match($pattern, $file)) {
            $matchingFiles[] = $file;
        }
    }

    // Close the directory
    closedir($directory);

    // Sort the matching files by name
    sort($matchingFiles);

    // Display the sorted file names
    foreach ($matchingFiles as $fileName) {
        echo $fileName . PHP_EOL;
    }
} else {
    echo "The specified folder does not exist.";
}
?>
