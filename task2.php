<?php

// Database connection settings
$hostname = "localhost"; 
$username = "root"; 
$password = "Test@123"; 
$database = "task";

// Create a database connection
$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// URL to download
$url = "https://www.wikipedia.org/";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$pageContent = curl_exec($curl);
curl_close($curl);

if ($pageContent === false) {
    die("Failed to download the page.");
}

$dom = new DOMDocument();
@$dom->loadHTML($pageContent);

// Extract and save data to the database
$sections = $dom->getElementsByTagName("section");

foreach ($sections as $section) {
    $title = $section->getElementsByTagName("h2")->item(0)->textContent;
    $abstract = $section->getElementsByTagName("p")->item(0)->textContent;
    $picture = $section->getElementsByTagName("img")->item(0)->getAttribute("src");
    $link = $section->getElementsByTagName("a")->item(0)->getAttribute("href");

    // Prepare SQL query to insert data into the database
    $dateCreated = date("Y-m-d H:i:s");
    $title = substr($title, 0, 230); 
    $url = substr($url, 0, 240);
    $picture = substr($picture, 0, 240); 
    $abstract = substr($abstract, 0, 256);

    $sql = "INSERT INTO wiki_sections (date_created, title, url, picture, abstract) 
            VALUES ('$dateCreated', '$title', '$url', '$picture', '$abstract')";

    $result = $connection->query($sql);
    if (!$result) {
        echo "Error: " . $connection->error;
    }
}

$connection->close();

?>
