<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$entries = []; // Mock data, replace with your database connection

if ($_GET['action'] == 'get_data') {
    // Mock data retrieval from the database
    $entries = [
        ["id" => 1, "name" => "Entry 1", "datetime" => "2023-11-03 12:00:00"],
        ["id" => 2, "name" => "Entry 2", "datetime" => "2023-11-03 14:00:00"]
    ];
    echo json_encode($entries);
} elseif ($_GET['action'] == 'add_entry') {
    $newName = $_POST['name'];
    // Mock data insertion into the database
    $newId = count($entries) + 1; // Mock new ID
    $newEntry = ["id" => $newId, "name" => $newName, "datetime" => date("Y-m-d H:i:s")];
    $entries[] = $newEntry;
    echo json_encode(["id" => $newId]);
} elseif ($_GET['action'] == 'update_entry') {
    $id = $_POST['id'];
    $newName = $_POST['name'];
    // Mock data update in the database
    foreach ($entries as &$entry) {
        if ($entry['id'] == $id) {
            $entry['name'] = $newName;
            break;
        }
    }
    echo json_encode(["success" => true]);
} elseif ($_GET['action'] == 'delete_entry') {
    $id = $_POST['id'];
    // Mock data deletion in the database
    foreach ($entries as $key => $entry) {
        if ($entry['id'] == $id) {
            unset($entries[$key]);
            break;
        }
    }
    echo json_encode(["success" => true]);
}
