<?php
    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $uuid = $connect->sanitized("uuid"); 
    $server = $connect->getLicenses($uuid); // fetch data
    $data = [];

    if ($server->num_rows > 0) {
        while ($row = $server->fetch_assoc()) {
            $array = array(
                "name" => $row['lname'],
                "uid" => $row['luid'],
                "lvendor" => $row['llvendor'],
                "total" => $row['ltotal'],
                "inuse" => $row['linuse'],
                "users" => json_decode($row['lusers']),
                "reservations" => json_decode($row['lreservations']),
                "sum" => $row['lsum']
            );

            $data[] = $array;
        }
        header('Content-Type: application/json');
        echo json_encode($data); // encode the entire array
    } else {
        header('Content-Type: application/json');
        echo json_encode([]);
    }

?>