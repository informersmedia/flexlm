<?php

    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $server_data = $connect->getUsers(); // fetch data
    $data_array = [];

    if ($server_data->num_rows > 0) {
        while ($row = $server_data->fetch_assoc()) {
            $data = array(
                "uuid" => $row['uuid'],
                "permission" => $row['permission'],
                "usr" => $row['usr'],
                "uemail" => $row['uemail'],
                "upwd" => $row['upwd'],
                "uproject" => $row['uproject'],
                "udomain" => $row['udomain']
            );

            $data_array[] = $data;
        }
        header('Content-Type: application/json');
        echo json_encode($data_array, JSON_PRETTY_PRINT); // encode the entire array
    } else {
        header('Content-Type: application/json');
        echo json_encode([]);
    }

    $server_data->close(); 
?>