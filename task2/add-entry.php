<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'];

    // Process the request and generate a new ID and datetime
    $newId = rand(1000, 9999);
    $newDatetime = date('Y-m-d H:i:s');

    $response = array('id' => $newId, 'datetime' => $newDatetime);
    echo json_encode($response);
}
